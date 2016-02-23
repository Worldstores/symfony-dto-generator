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
    protected $parents = array();
    
    /**
     * @var array 
     */
    protected $children = array();
    
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
     * Whether the elemet is cdata
     * 
     * @var boolean
     */
    protected $cdata;
    
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
    
    public function addChild($child)
    {
        $this->children[] = $child;
        
        return $this;
    }
    
    public function setChildren($children)
    {
        $this->children = $children;
        
        return $this;
    }
    
    public function getChildren()
    {
        return $this->children;
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
    
    public function setCdata($cdata)
    {
        $this->cdata = $cdata;
        
        return $this;
    }
    
    public function getCdata()
    {
        return $this->cdata;
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