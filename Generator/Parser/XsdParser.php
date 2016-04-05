<?php

namespace WsSys\DtoGeneratorBundle\Generator\Parser;

use WsSys\DtoGeneratorBundle\Generator\Parser;
use WsSys\DtoGeneratorBundle\Generator\DataMapper;
use WsSys\DtoGeneratorBundle\Generator\Parser\Interfaces\ParserInterface;

/**
 * Reads Xsd and it's elements
 */
class XsdParser implements ParserInterface
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
    public function parse($source)
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
                $element = new Parser\Element\ComplexTypeElement();
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
                            $element = new Parser\Element\ComplexTypeElement();
                            $element->setName($node->getAttribute('name'));
                            $this->setComplexTypeChildrenRecursively($node, $element);
                            
                            $parentElement->addChild($element);
                            
                        } elseif ($this->isCustomTypeNode($node)) {
                            $element = new Parser\Element\ComplexTypeElement();
                            $element->setName($node->getAttribute('name'));
                            $this->setCustomTypeChildrenRecursively($node, $element);
                            
                            $parentElement->addChild($element);

                        } else {
                            $element = new Parser\Element\Element();
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
    
    
    /**
     * Checks if the node is custom Type which is user Defined. 
     * It is a Complex type but name given by user. 
     * 
     * If given type of the element is not ComplexType but there is root level element with that name, 
     * it is supposed to be custom Node..
     * 
     * Example of XML
     * <?xml version="1.0" encoding="UTF-8"?>
     * <xs:schema xmlns:xs="http://www.w3.org/2001/XMLSchema">
        <xs:element name="oUm">
          <xs:annotation>
            <xs:documentation>This is an example of complex Element</xs:documentation>
          </xs:annotation>
          <xs:complexType>
            <xs:sequence>
              <xs:element name="id">
                <xs:annotation>
                  <xs:documentation>Unique id</xs:documentation>
                </xs:annotation>
                <xs:simpleType>
                  <xs:restriction base="xs:string">
                    <xs:maxLength value="100"/>
                    <xs:minLength value="1"/>
                  </xs:restriction>
                </xs:simpleType>
              </xs:element>        
              <xs:element name="billToAddress" type="addressType" minOccurs="0">
                <xs:annotation>
                  <xs:documentation>Bill to address</xs:documentation>
                </xs:annotation>
              </xs:element>
            </xs:sequence>
          </xs:complexType>
        </xs:element>
        <xs:element name="address" type="addressType"/>
        <xs:complexType name="addressType">
          <xs:all>
            <xs:element name="title" type="xs:string" minOccurs="0">
              <xs:annotation>
                <xs:documentation>Customer title</xs:documentation>
              </xs:annotation>
            </xs:element>
          </xs:all>
        </xs:complexType>
      </xs:schema>
     * 
     * @param DomNode $node
     * 
     * @return boolean
     */
    protected function isCustomTypeNode($node)
    {
        $nodes = $this->start->childNodes;

        $nodeType = $node->nodeType;
        $typeAttribute = $node->getAttribute('type');
        
        if ($nodeType === XML_ELEMENT_NODE) {
            if (!empty($typeAttribute)) {
                foreach ($nodes as $node) {
                    //If any Node exists with the same name as Attribute Type defined for any element
                    if (method_exists($node, 'getAttribute')) {            
                        if ($typeAttribute === $node->getAttribute('name')) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    
    /**
     * Sets Children of Custom Type Recursively
     * @param DomNode $node
     * @param Element $element
     */
    protected function setCustomTypeChildrenRecursively($node, &$element)
    {
        $nodes = $this->start->childNodes;
        $typeAttribute = $node->getAttribute('type');

        foreach ($nodes as $node) {
            //If any Node exists with the same name as Attribute Type defined for any element
            if (method_exists($node, 'getAttribute')) {            
                if ($typeAttribute === $node->getAttribute('name')) {
                    $this->addChildrenElements($node, $element);
                }
            }
        }
    }
}