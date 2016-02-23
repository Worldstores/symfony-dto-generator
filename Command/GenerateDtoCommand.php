<?php

namespace WsSys\DtoGeneratorBundle\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use WsSys\DtoGeneratorBundle\Generator\XsdToDtoGenerator;

/**
 * Command to generate the Dtos
 */
class GenerateDtoCommand extends GeneratorCommand implements ContainerAwareInterface
{
    /**
     * All the supported Types eg: xsd, json
     * @var array 
     */
    protected $supportedTypes = array('xsd');
    
    /**
     * @var ContainerInterface 
     */
    protected $container;
    
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
    	$this
        ->setName('generate:dto')
        ->setDescription('Convert Xml/Json into PHP.')
        ->setDefinition(array(
            new InputArgument(
                'src', InputArgument::REQUIRED, 'The path of the souce XSD or JSON.'
            ),
            new InputArgument(
                'destination', InputArgument::REQUIRED, 'The path to save DTOs.'
            ),
            new InputArgument(
                'destinationNS', InputArgument::REQUIRED, 'The target namespace for DTOs'
            ),
            new InputArgument(
                'type', InputArgument::REQUIRED, 'The path to save DTOs.'
            ),
        ))
        ->setHelp("Generate DTOs from Given source (Json/Xml).");

    }
    
    /**
     * Sets the container 
     * 
     * @param ContainerInterface $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
    	$this->container = $container;
    }
    
    /**
     * @return ContainerInterface
     */
    protected function getContainer()
    {
    	if (null === $this->container) {
    		$this->container = $this->getApplication()->getKernel()->getContainer();
    	}
    	return $this->container;
    }
    
    /**
     * Execute Command
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return type
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $type = $input->getArgument('type');
        
        if (!in_array($type, $this->supportedTypes)) {
            throw new \Exception('We don\'t know yet, how to generate DTOs from ' . $type . '.');
        }
        
        $src = $input->getArgument('source');
        $destination = $input->getArgument('destination');
        $destinationNS = $input->getArgument('destinationNS');

        if (!is_dir($destination)) {
            throw new \Exception("Destination must be a directory.");
        }
        
        $generator = $this->getGenerator();
        $generator->setSource($src)
                    ->setDestination($destination)
                    ->setDestinationNS($destinationNS)
                    ->generate();
                
        echo 'Generated All the DTOs';
    }
    
    /**
     * {@inheritdoc}
     * @param BundleInterface $bundle
     * 
     * @return array
     */
    protected function getSkeletonDirs(BundleInterface $bundle = null)
    {
        $skeletonDirs = array();
        $skeletonDirs[] = __DIR__.'/../Resources/skeleton';
        return $skeletonDirs;
    }
    
    /**
     * creates a generator
     * @return XsdToDtoGenerator
     */
    protected function createGenerator()
    {
        return new XsdToDtoGenerator($this->getContainer()->get('filesystem'));
    }
}