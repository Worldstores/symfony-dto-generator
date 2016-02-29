<?php

namespace WsSys\DtoGeneratorBundle\Generator\Reader;

use WsSys\DtoGeneratorBundle\Generator\Reader;
use WsSys\DtoGeneratorBundle\Generator\DataMapper;

/**
 * Reads Xsd and it's elements
 */
class XsdReader
{
    /**
     * @var \DOMDocument 
     */
    protected $dom;
    
    /**
     * @var \DOMElement 
     */
    protected $start;
    
    /**
     * Reads the XSD from given source
     * @param string $source
     */
    public function read($source)
    {
        $this->dom = new \DOMDocument();
        $this->dom->load($source);
        $this->start = $this->dom->documentElement;
    }
    
    /**
     * Return First Element from Xsd
     * 
     * @return Element | null if not found
     */
    public function getFirstElementWithChildren()
    {
        $nodes = $this->start->childNodes;
        foreach ($nodes as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $element = new Reader\Xsd\ComplexTypeElement();
                $element->setName($node->getAttribute('name'))
                        ->setElementAsFirst(true);
                
                $this->addChildrenElements($node, $element);

                return $element;
            }
        }
        return null;
    }
    
    /**
     * Add Children Elements to the given parentElement
     * 
     * @param DOMNode $parentNode
     * @param Element $parentElement
     */
    protected function addChildrenElements($parentNode, &$parentElement) 
    {
        $children = $parentNode->childNodes;

        foreach ($children as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                switch ($node->localName) {
                    case 'complexType':
                    case 'all':
                    case 'sequence':
                        /**
                         * Recursively looking at element(localName=element)node
                         */
                        $this->addChildrenElements($node, $parentElement);
                        break;
                    case 'element':
                        if ($this->isComplexTypeNode($node)) {
                            $element = new Reader\Xsd\ComplexTypeElement();
                            $element->setName($node->getAttribute('name'));
                            $this->setComplexTypeChildrenRecursively($node, $element);
                            
                            $parentElement->addChild($element);
                        } else {
                            $element = new Reader\Xsd\Element();
                            $element->setName($node->getAttribute('name'));

                            if ($node->getAttribute('type')) {
                                $element->setDataType(DataMapper\DataTypeMapper::XsdToDto($node->getAttribute('type')));
                            } else {
                                $this->setElementsDataType($node, $element);
                            }
                            $parentElement->addChild($element);
                        }
                        break;
                }
            }
        }
    }
    
    /**
     * Recursively looks at an element which has DataType and sets the type of the element
     * 
     * @param DOMNode $node
     * @param Element $element
     */
    protected function setElementsDataType($node, &$element)
    {
        $childNodes = $node->childNodes;
        
        foreach ($childNodes as $childNode) {
            $localName = $childNode->localName;
            if ($localName == 'simpleType') {
                $this->setElementsDataType($childNode, $element);
            } elseif ($localName == 'restriction' ) {
                $element->setDataType(DataMapper\DataTypeMapper::XsdToDto($childNode->getAttribute('base')));
                return;
            }
        }
    }
    
    /**
     * Checks if the node is complex type of node
     * @param DomNode $node
     * 
     * @return boolean
     */
    protected function isComplexTypeNode($node)
    {
        $childNodes = $node->childNodes;
        
        foreach ($childNodes as $childNode) {
            $localName = $childNode->localName;
            if ($localName == 'complexType') {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Sets Children of Complex Type Recursively
     * @param DomNode $node
     * @param Element $element
     */
    protected function setComplexTypeChildrenRecursively($node, &$element)
    {
        $childNodes = $node->childNodes;
        
        foreach ($childNodes as $childNode) {
            $localName = $childNode->localName;
            if ($childNode->nodeType === XML_ELEMENT_NODE && $localName == 'complexType') {
                $this->addChildrenElements($childNode, $element);
            }
        }
    }
}