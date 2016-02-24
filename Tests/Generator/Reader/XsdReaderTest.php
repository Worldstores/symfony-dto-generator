<?php

namespace WsSys\DtoGeneratorBundle\Tests\Generator\Reader;

use WsSys\DtoGeneratorBundle\Generator\Reader\XsdReader;


class XsdReaderTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @var Reader 
     */
    private $reader;
    
    private $source;
        
    public function setUp() 
    {
        $this->source = __DIR__ . '/../XSD/PO.xsd';
        $this->reader = new XsdReader();
        parent::setUp();
    }
    
    public function testGetFirstElementWithChildrenReturnElementsWithItsChildren()
    {
        $this->reader->read($this->source);
        $retval = $this->reader->getFirstElementWithChildren();
        
        $this->assertCount(13, $retval->getChildren());
        $this->assertInstanceOf('WsSys\DtoGeneratorBundle\Generator\Reader\Xsd\Element', $retval->getChildren()[0]);
        $this->assertCount(3, $retval->getComplexElementChildren());
    }
    
}