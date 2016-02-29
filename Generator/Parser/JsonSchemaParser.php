<?php

namespace WsSys\DtoGeneratorBundle\Generator\Parser;

use WsSys\DtoGeneratorBundle\Generator\Parser;
use WsSys\DtoGeneratorBundle\Generator\Parser\Interfaces\ParserInterface;

/**
 * Reads Json and it's elements
 */
class JsonSchemaParser implements ParserInterface
{
    
    /**
     * @var RecursiveIteratorIterator 
     */
    private $start;
    
    /**
     * Reads the Json from given source
     * 
     * @param string $source
     */
    public function parse($source)
    {
        $json = file_get_contents($source);
        $jsonIterator = new \RecursiveIteratorIterator(
                new \RecursiveArrayIterator(json_decode($json, TRUE)), 
                \RecursiveIteratorIterator::SELF_FIRST
            );

        $this->start = $jsonIterator;
    }
    
    /**
     * Return First Element from Json Schema
     * 
     * @return Element | null if not found
     */
    public function getFirstElementWithChildren()
    {
        foreach ($this->start as $key => $node) {
            if ($key === 'properties' || $key === 'items') {
                foreach ($node as $name => $value) {
                    $element = new Element\ComplexTypeElement();
                    $element->setName($name)
                            ->setElementAsFirst(true);

                    $this->addChildrenElements($value, $element);
                    return $element;
                }
            }
        }
        return null;
    }
    
    /**
     * Add Children Elements to the given parentElement
     * 
     * @param array $parentNode
     * @param Element $parentElement
     */
    protected function addChildrenElements($parentNode, &$parentElement) 
    {
        $nodes = array_key_exists('properties', $parentNode) 
                 ? $parentNode['properties']
                 : array();
        
        foreach ($nodes as $name => $node) {
            $nodeType = $node['type'];

            switch ($nodeType) {
                case 'object':
                    $element = new Parser\Element\ComplexTypeElement();
                    $element->setName($name);
                    $parentElement->addChild($element);
                    /**
                     * Recursively loads objects
                     */
                    $this->addChildrenElements($node, $element);
                    break;
                case 'array':
                    $element = new Parser\Element\ComplexTypeElement();
                    $element->setName($name);
                    $parentElement->addChild($element);
                    /**
                     * Recursively loads objects
                     */
                    if (array_key_exists('items', $node)) {
                        $this->addChildrenElements($node['items'], $element);
                    }
                    break;
                default:
                    $element = new Parser\Element\Element();
                    $element->setName($name)
                            ->setDataType($nodeType);
                    $parentElement->addChild($element);
                    break;
            }
        }
    }
}