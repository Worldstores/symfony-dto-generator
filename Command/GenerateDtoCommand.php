<?php

namespace WsSys\DtoGeneratorBundle\Command;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console;
use Goetas\Xsd\XsdToPhp\Command\Server;

/**
 * Command to generate the Dtos
 */
class GenerateDtoCommand extends Server implements ContainerAwareInterface
{
    /**
     * All the supported Types eg: xml, json
     * @var array 
     */
    protected $supportedTypes = array('xml');
    
    /**
     * @var ContainerInterface 
     */
    protected $container;
    
    /**
     * @see Console\Command\Command
     */
    protected function configure()
    {
    	parent::configure();
         $this
        ->setName('generate:dto');

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
        
        $input->setArgument('type', $type);
    	$input->setArgument('destination', $this->convertBundlePathToActualPath($input->getArgument('destination')));
    	$input->setArgument('source', $this->convertBundlePathToActualPath($input->getArgument('source')));
    	return parent::execute($input, $output);
    }
    
    /**
     * Converts Bundles Path to Actual Path
     * @param string $path
     * @return string
     */
    protected function convertBundlePathToActualPath($path) 
    {
    	$bundleNameSeparatorPosition = strpos(':', $path);
        
        if ($bundleNameSeparatorPosition > 0) {
            $bundleName = substr($path, 0, $bundleNameSeparatorPosition);
            $bundle = $this->getContainer()->get("kernel")->getBundle($bundleName);
            $bundlePath = $bundle->getPath(); 
            return $bundlePath . substr($path, $bundleNameSeparatorPosition);
        }
        return $path;
    }
}