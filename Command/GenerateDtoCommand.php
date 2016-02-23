<?php

namespace WsSys\DtoGeneratorBundle\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console;
use Symfony\Component\Console\Command\Command;
use WsSys\DtoGeneratorBundle\Generator\XsdToDtoGenerator;

/**
 * Command to generate the Dtos
 */
class GenerateDtoCommand extends Command implements ContainerAwareInterface
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
        
        $xsdToDtoGenerator = new XsdToDtoGenerator($src, $destination, $destinationNS);
        try {
            $xsdToDtoGenerator->setSource($src)
                    ->setDestination($destination)
                    ->setDestinationNS($destinationNS)
                    ->generate();
  
        } catch (\Exception $e) {
            echo 'Dto Could not be generated. ' . $e->getMessage();
        } 
        echo 'Generated All the DTOs';
    }
}