<?php

namespace WsSys\DtoGeneratorBundle\Tests\Generator\Parser;

use WsSys\DtoGeneratorBundle\Generator\Parser\JsonSchemaParser;


class JosonSchemaParserTest extends \PhpUnit_Framework_TestCase
{
    /**
     * @var Parser 
     */
    private $parser;
    
    private $source;
        
    public function setUp() 
    {
        $this->source = __DIR__ . '/../JsonSchema/robot.schema.json';
        $this->parser = new JsonSchemaParser();
        parent::setUp();
    }
    
    public function testGetFirstElementWithChildrenReturnElementsWithItsChildren()
    {
        $this->parser->parse($this->source);
        $retval = $this->parser->getFirstElementWithChildren();
        
        $this->assertCount(6, $retval->getChildren());
        $this->assertInstanceOf('WsSys\DtoGeneratorBundle\Generator\Parser\Element\Element', $retval->getChildren()[0]);
        $this->assertCount(2, $retval->getComplexElementChildren());
    }
}