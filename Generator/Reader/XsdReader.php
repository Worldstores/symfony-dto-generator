<?php

namespace WsSys\DtoGeneratorBundle\Generator\Reader;

use WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element;
use WsSys\DtoGeneratorBundle\Generator\DataMapper\DataTypeMapper;

/**
 * Reads Xsd and it's elements
 */
class XsdReader
{
    
    protected $dom;
    
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
                $element = new \WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\ComplexTypeElement();
                $element->setName($node->getAttribute('name'))
                        ->setFirstElement(true);
                
                $this->getChildrenNodes($node, $element);

                return $element;
            }
        }
        return null;
    }
    
    public function getChildrenNodes($parentNode, &$parentElement) 
    {
        $retval = array();
        $children = $parentNode->childNodes;

        /**
         * Need to look at the node type whose namespace is element.. then only it will work. 
         */
        foreach ($children as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $localName = $node->localName;
                
                switch ($localName) {
                    case 'complexType':
                    case 'all':
                    case 'sequence':
                        //returns the nodes under the complex type
                        $this->getChildrenNodes($node, $parentElement);
                        break;
                    case 'element':
                        if ($this->isComplexTypeNode($node)) {
                            $element = new \WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\ComplexTypeElement();
                            $element->setName($node->getAttribute('name'));
                            $this->setComplexTypeChildrenRecursively($node, $element);
                            
                            $parentElement->addChild($element);
                        } else {
                            $element = new \WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element();
                            $element->setName($node->getAttribute('name'));

                            if ($node->getAttribute('type')) {
                                $element->setType(DataTypeMapper::XsdToDto($node->getAttribute('type')));
                            } else {
                                $this->setElementType($node, $element);
                            }
                            $parentElement->addChild($element);
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }
    
    /**
     * Recursively looks at an element with type and sets the type of the element
     * @param DOMNode $node
     * @param Element $element
     */
    protected function setElementType($node, &$element)
    {
        $childNodes = $node->childNodes;
        
        foreach ($childNodes as $childNode) {
            $localName = $childNode->localName;
            if ($localName == 'simpleType') {
                $this->setElementType($childNode, $element);
            } elseif ($localName == 'restriction' ) {
                $element->setType(DataTypeMapper::XsdToDto($childNode->getAttribute('base')));
                return;
            } else {
                continue;
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
                $this->getChildrenNodes($childNode, $element);
            }
        }
    }
}