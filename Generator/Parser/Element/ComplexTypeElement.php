<?php

namespace WsSys\DtoGeneratorBundle\Generator\Parser\Element;

/**
 * Element Which has children element..
 */
class ComplexTypeElement extends Element
{
    /**
     * @var array 
     */
    protected $children = array();
    
    /**
     * Add a child to the element
     * 
     * @param Element $child
     * @return ComplexTypeElement
     */
    public function addChild($child)
    {
        $this->children[] = $child;
        
        return $this;
    }
    
    /**
     * Set Children Elements for the element
     * @param array $children
     * 
     * @return ComplexTypeElement
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }
    
    /**
     * Get all the children Element
     * 
     * @return array
     */
    public function getChildren()
    {
        return $this->children;
    }
    
    /**
     * Returns only Children which has complex element children
     * 
     * @return array
     */
    public function getComplexElementChildren()
    {
        $complexTypeElements = array();
        foreach ($this->children as $child) {
            if ($child instanceof ComplexTypeElement) {
                $complexTypeElements[] = $child;
            }
        }
        return $complexTypeElements;
    }
}