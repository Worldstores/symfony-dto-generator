<?php

namespace WsSys\DtoGeneratorBundle\Generator;

use Sensio\Bundle\GeneratorBundle\Generator\Generator;
use WsSys\DtoGeneratorBundle\Exception\InvalidArgumentException;

/**
 * Abstract to Generate the Dtos from Source
 * 
 * @since 2016.02.29
 */
abstract class AbstractGenerator extends Generator
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
    protected $destinationNamespace;
    
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
     * @return AbstractGenerator
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
     * @return AbstractGenerator
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
     * @return AbstractGenerator
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
     * @param boolean $forceOverwrite | whether to overwrite existing file.
     */
    abstract public function generate($forceOverwrite = true);
    
    /**
     * Validates the Input 
     * 
     * @throws InvalidArgumentException
     */
    protected function validateInput()
    {
        $source = $this->getSource();
        if (!$source) {
            throw new InvalidArgumentException('Source');
        }
        
        $destination = $this->getDestination();
        if (!is_dir($destination)) {
            throw new InvalidArgumentException('Destination');
        }
        
        $destinationNS = $this->getDestinationNamespace();
        if (!$destinationNS) {
            throw new InvalidArgumentException('DestinationNamespace');
        }
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
            if ($element instanceof Parser\Element\ComplexTypeElement) {
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
     * @throws \LogicException
     */
    protected function generateDTOClass($element, $forceOverwrite)
    {
        if (!$forceOverwrite && is_file($this->target)) {
            throw new \LogicException ('File already exists and you have not asked to overwrite.');
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
