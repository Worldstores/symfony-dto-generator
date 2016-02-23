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
}

