<?php

namespace WsSys\DtoGeneratorBundle\Generator\Reader\Xsd;

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
     * @var array 
     */
    protected $parent;
    
    /**
     * @var DOMNode 
     */
    protected $node;
    
    /**
     * Declares if its first element
     * 
     * @var boolean
     */
    protected $firstElement;
    
    /**
     * Type of the element
     * 
     * @var string 
     */
    protected $type;
    
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
    
    public function getUcfirstName()
    {
        return ucfirst($this->name);
    }


    /**
     * @param DOMNode $node
     * @return Element
     */
    public function setNode($node)
    {
        $this->node = $node;
        return $this;
    }
    
    /**
     * @return DomNode
     */
    public function getNode()
    {
        return $this->node;
    }
    
    public function setFirstElement($firstElement)
    {
        $this->firstElement = $firstElement;
        
        return $this;
    }
    
    public function getFirstElement()
    {
        return $this->firstElement;
    }
    
    public function setType($type)
    {
        $this->type = $type;
        
        return $this;
    }
    
    public function getType()
    {
        return $this->type;
    }
}