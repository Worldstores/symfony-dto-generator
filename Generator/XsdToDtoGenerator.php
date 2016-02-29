<?php

namespace WsSys\DtoGeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use WsSys\DtoGeneratorBundle\Exception\InvalidArgumentException;
use WsSys\DtoGeneratorBundle\Generator\Reader\XsdReader;

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
    protected $destinationNamaspace;
    
    /**
     * Target File
     * 
     * @var string 
     */
    protected $target;
    
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
     * @param string $destinationNamespace
     * 
     * @return XsdToDtoGenerator
     */
    public function setDestinationNamespace($destinationNamespace) 
    {
        $this->destinationNamespace = $destinationNamespace;
        return $this;
    }

    /**
     * Gets the Destination Namespace
     * 
     * @return string
     */
    public function getDestinationNamespace() 
    {
        return $this->destinationNamespace;
    }

    /**
     * Generates the DTOs
     * 
     * @param boolean $forceOverwrite
     * @throws InvalidArgumentException
     */
    public function generate($forceOverwrite = true)
    {
        $source = $this->getSource();
        if (!$source) {
            throw new InvalidArgumentException('Source');
        }
        
        $destination = $this->getDestination();
        if (!is_dir($destination)) {
            throw new InvalidArgumentException('Destination');
        }
        
        $destinationNamespace = $this->getDestinationNamespace();
        if (!$destinationNamespace) {
            throw new InvalidArgumentException('DestinationNamespace');
        }

        $reader = new XsdReader();
        $reader->read($source);
        
        $firstElement = $reader->getFirstElementWithChildren();
        $this->genereateDTOClasses($firstElement, $forceOverwrite);
    }
    
    /**
     * Returns a target file
     * 
     * @return string
     */
    protected function setTargetFile($elementName)
    {
        $this->target = sprintf("%s/%s.%s", $this->destination, $elementName, 'php');
        
        return $this;
    }
    
    /**
     * Generates DTO Classes
     * 
     * @param Element $firstElementWithChildren
     * @param boolean $forceOverwrite
     */
    protected function genereateDTOClasses($firstElementWithChildren, $forceOverwrite)
    {
        foreach ($firstElementWithChildren->getChildren() as $element) {
            if ($element instanceof Reader\Xsd\ComplexTypeElement) {
                $element->setDataType($this->getTypeForChildDto($element));
                $this->genereateDTOClasses($element, $forceOverwrite);
            }
        }
        $this->setTargetFile(ucfirst($firstElementWithChildren->getName()));
        $this->generateDTOClass($firstElementWithChildren, $forceOverwrite);
    }

    /**
     * Creates a file
     * 
     * @param Element $element
     * @param boolean $forceOverwrite
     * @throws \LogicException
     */
    protected function generateDTOClass($element, $forceOverwrite)
    {
        if (!$forceOverwrite && is_file($this->target)) {
            throw new \LogicException('File already exists and you have not asked to overwrite.');
        }
        
        $this->renderFile('dto.php.twig', $this->target, array(
            'namespace' => $this->destinationNamespace,
            'element' => $element
        ));
    }
    
    /**
     * Get Name for Child DTO
     * @param Element $element
     * @return string
     */
    protected function getTypeForChildDto($element)
    {
        return $this->destinationNamespace . '\\' . ucfirst($element->getName());
    }
}