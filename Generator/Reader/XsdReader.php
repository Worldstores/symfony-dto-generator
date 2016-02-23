<?php

namespace WsSys\DtoGeneratorBundle\Generator\Reader;

use WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element;

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
    public function getFirstElement()
    {
        $nodes = $this->start->childNodes;
        foreach ($nodes as $node) {
            if ($node->nodeType === XML_ELEMENT_NODE) {
                $element = new \WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element();
                $element->setName($node->getAttribute('name'))
                        ->setNode($node)
                        ->setFirstElement(true);
                
                $children = $this->getChildrenNodes($node);
                $element->setChildren($children);
                
                return $element;
            }
        }
        return null;
    }
    
    public function getChildrenNodes($node) 
    {
        $retval = array();
        $children = $node->childNodes;
        
        foreach($children as $item) {
          if ($item->nodeType === XML_ELEMENT_NODE) {
                $element = new \WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element();
                $element->setName($item->getAttribute('name'))
                        ->setNode($item)
                        ->setCdata(false)
                        ->setType('string');
            $retval[] = $element;    
          } 
        }
        return $retval;
    }
    
    
//    public function getChildrenNodes($node) 
//    {
//        $child = $node->childNodes;
//        
//        foreach($child as $item) {
//            
//          if ($item->nodeType == XML_TEXT_NODE) {
//            if (strlen(trim($item->nodeValue))) {
//                echo trim($item->nodeValue). "\r\n";
//            }
//          } 
//          
//          else if ($item->nodeType == XML_ELEMENT_NODE) {
//              
//              $name = $item->getAttribute('name');
//              echo $name . "\r\n";  
//              
//              $type = $item->getAttribute('type');
//              echo 'Type: ' . $type . "\r\n";
//              
//              $minOccurs = $item->getAttribute('minOccurs');
//              echo 'min: ' . $minOccurs . "\r\n";
//              
//              $this->getNodes($item);
//          }
//        }
//    }
}