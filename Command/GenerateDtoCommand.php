<?php

namespace WsSys\DtoGeneratorBundle\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console;
use Symfony\Component\HttpKernel\Bundle\BundleInterface;
use Sensio\Bundle\GeneratorBundle\Command\GeneratorCommand;
use WsSys\DtoGeneratorBundle\Generator;

/**
 * Command to generate the Dtos
 */
class GenerateDtoCommand extends GeneratorCommand
{
    /**
     * All the supported Types eg: xsd, json
     * @var array 
     */
    protected $supportedTypes = array('xsd', 'json');
    
    /**
     * Type of the source
     * 
     * @var string 
     */
    protected $type;
    
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
    	$this
        ->setName('ws:generator:generate:dto')
        ->setAliases(array('ws:generator:dto:generate'))
        ->setDescription('Convert Xml/Json into PHP.')
        ->setDefinition(array(
            new InputArgument(
                'source', InputArgument::REQUIRED, 'The path of the souce XSD or JSON.'
            ),
            new InputArgument(
                'destination', InputArgument::REQUIRED, 'The path to save DTOs.'
            ),
            new InputArgument(
                'destination-namespace', InputArgument::REQUIRED, 'The target namespace for DTOs'
            ),
            new InputArgument(
                'src-type', InputArgument::REQUIRED, sprintf('The type of the source. Available types: %s', implode(', ', $this->supportedTypes))
            ),
            new InputArgument(
                'generate-controller', InputArgument::OPTIONAL, sprintf('set this option to 1 if you want to generate controllers too')
            ),
            new InputArgument(
                'target-bundle', InputArgument::OPTIONAL, sprintf('The bundle where to generate the controller')
            ),
        ))
        ->setHelp("Generate DTOs from Given source (Json/Xml).");
    }
    
    /**
     * Execute Command
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->type = $input->getArgument('src-type');
        
        if (!in_array($this->type, $this->supportedTypes)) {
            throw new \LogicException('We don\'t know yet, how to generate DTOs from ' . $this->type . '.');
        }
        
        $src = $input->getArgument('source');
        $destination = $input->getArgument('destination');
        $destinationNS = $input->getArgument('destination-namespace');

        if (!is_dir($destination)) {
            throw new \LogicException("Destination must be a directory.");
        }
        
        $generator = $this->getGenerator();
        $dto = $generator->setSource($src)
                ->setDestination($destination)
                ->setDestinationNamespace($destinationNS)
                ->generate();
                
        $output->writeln('Generated All the DTOs');
        
        /**
         * Checks if Controller needs to be generated, and execute the generator
         */
        $generateController = $input->getArgument('generate-controller');
        if ($generateController) {
            $this->executeControllerGenerator($input, $output, $dto);
        }
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
        switch($this->type) {
            case 'xsd':
                return new Generator\XsdToDtoGenerator();
            case 'json':
                return new Generator\JsonSchemaToDtoGenerator();
        }
    }

    /**
     * Execute Command To generate Controller
     * 
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function executeControllerGenerator(InputInterface $input, OutputInterface $output, $dto)
    {
        $targetBundle = $input->getArgument('target-bundle');

        if (empty($targetBundle)) {
            throw new \LogicException("Bunle is not provided. We don't know where to create the controller");
        }
        
        $bundle = $this->getContainer()->get('kernel')->getBundle($targetBundle);
        
        $dataFormat = ($this->type === 'XSD') ? 'XML' : 'JSON';

        $generator = $this->getControllerGenerator();
        $generator->setDtoClassName($dto)
                ->setDataFormat($dataFormat)
                ->setBundle($bundle)
                ->generate(TRUE);
                
        $output->writeln('Generated All the DTOs');
    }
    
    /**
     * Returns Controller Generator
     * 
     * @return Generator\ApiControllerGenerator
     */
    protected function getControllerGenerator()
    {
        return new Generator\ApiControllerGenerator();
    }
}