<?php

namespace WsSys\DtoGeneratorBundle\Generator\Parser\Element;

/**
 * Element Which will help to create a DTO
 */
class Element
{
    /**
     * @var string 
     */
    protected $name;
    
    /**
     * @var array 
     */
    protected $attributes = array();
    
    /**
     * Declares if its first element
     * 
     * @var boolean
     */
    protected $firstElement;
    
    /**
     * Type of data that the element holds
     * 
     * @var string 
     */
    protected $dataType;
    
    /**
     * @param string $name
     * 
     * @return Element
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Return name with uppercase first character
     * 
     * @return string
     */
    public function getUcfirstName()
    {
        return ucfirst($this->name);
    }
    
    /**
     * Sets type of data that an Element holds
     * 
     * @param string $type
     * @return Element
     */
    public function setDataType($type)
    {
        $this->dataType = $type;
        
        return $this;
    }
    
    /**
     * Gets type of data that an elements holds
     * 
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Sets the Element as first
     * 
     * @param boolean $firstElement
     * @return Element
     */
    public function setElementAsFirst($firstElement)
    {
        $this->firstElement = $firstElement;
        return $this;
    }
    
    /**
     * Checks if the element is first Element
     * 
     * @return boolean
     */
    public function isFirstElement()
    {
        return $this->firstElement;
    }
}