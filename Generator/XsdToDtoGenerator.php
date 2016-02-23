<?php

namespace WsSys\DtoGeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use WsSys\DtoGeneratorBundle\Exception\InvalidArgumentException;
use WsSys\DtoGeneratorBundle\Generator\Reader\XsdReader;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Generate the Dtos from Xsd
 */
class XsdToDtoGenerator extends Generator
{
    /**
     * Source file location
     * 
     * @var string 
     */
    protected $source;
    
    /**
     * Destination file location
     * 
     * @var string 
     */
    protected $destination;
    
    /**
     * Namespace of the DTO Object(s)
     * 
     * @var string 
     */
    protected $destinationNS;
    
    /**
     * Target File
     * 
     * @var string 
     */
    protected $target;
    
    /**
     * @var Filesystem
     */
    protected $filesystem;
    
    /**
     * Constructor.
     *
     * @param Filesystem $filesystem A Filesystem instance
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem  = $filesystem;
    }
    
    /**
     * Sets the source
     * 
     * @param string $source
     * 
     * @return XsdToDtoGenerator
     */
    public function setSource($source) 
    {
        $this->source = $source;
        return $this;
    }
    
    /**
     * Gets the source
     * 
     * @return string
     */
    public function getSource() 
    {
        return $this->source;
    }

    /**
     * Sets the destination 
     * 
     * @param string $destination
     * 
     * @return XsdToDtoGenerator
     */
    public function setDestination($destination) 
    {
        $this->destination = $destination;
        return $this;
    }
    
    /**
     * Gets the destination
     * 
     * @return string
     */
    public function getDestination() 
    {
        return $this->destination;
    }
    
    /**
     * Sets the destination Namespace
     * 
     * @param string $destinationNS
     * 
     * @return XsdToDtoGenerator
     */
    public function setDestinationNS($destinationNS) 
    {
        $this->destinationNS = $destinationNS;
        return $this;
    }

    /**
     * Gets the Destination Namespace
     * 
     * @return string
     */
    public function getDestinationNS() 
    {
        return $this->destinationNS;
    }

    /**
     * Generates the DTOs
     * 
     * @throws InvalidArgumentException
     */
    public function generate($forceOverwrite = true, $format = 'php')
    {
        $this->setFormat($format);
        $source = $this->getSource();
        if (!$source) {
            throw new InvalidArgumentException('Source');
        }
        
        $destination = $this->getDestination();
        if (!is_dir($destination)) {
            throw new InvalidArgumentException('Destination');
        }
        
        $destinationNS = $this->getDestinationNS();
        if (!$destinationNS) {
            throw new InvalidArgumentException('DestinationNS');
        }

        $reader = new XsdReader();
        $reader->read($source);
        
        $firstElement = $reader->getFirstElement();
        $this->setTargetFile(ucfirst($firstElement->getName()));
        $this->generateDTOClass($firstElement, $forceOverwrite);
    }
    
    /**
     * Returns a target file
     * 
     * @return string
     */
    protected function setTargetFile($elementName)
    {
        $this->target = sprintf("{$this->destination}/%s.%s", $elementName, $this->format);
        return $this;
    }

    /**
     * Sets the configuration format.
     *
     * @param string $format The configuration format
     */
    protected function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * Creates a file
     * @param Element $element
     * @throws \RuntimeException
     */
    protected function generateDTOClass($element, $forceOverwrite)
    {
        if (!$forceOverwrite && is_file($this->target)) {
            throw new \Exception ('File already exists and you have not asked to overwrite.');
        }
        
        $this->renderFile('dto.php.twig', $this->target, array(
            'namespace' => $this->destinationNS,
            'element' => $element
        ));
    }
}