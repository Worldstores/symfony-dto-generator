<?php

namespace WsSys\DtoGeneratorBundle\Generator\Reader\Xsd;

/**
 * Element Which will help to create a DTO
 */
class ComplexTypeElement extends Element
{
    /**
     * @var array 
     */
    protected $children = array();
    
    
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
    
    
}