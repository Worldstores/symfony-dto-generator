<?php

namespace WsSys\DtoGeneratorBundle\Tests\Functional\Generator;

use WsSys\DtoGeneratorBundle\Generator\XsdToDtoGenerator;

/**
 * Test by creating real file. It is useful when trying to look at the output (for development)
 * 
 * @group functional
 */
class XsdToDtoGeneratorTest extends \PhpUnit_Framework_TestCase
{
    
    private $generator;
    
    private $source;
    
    private $destination;
    
    private $destinationNS;
    
    public function setUp() 
    {
        $this->source = __DIR__ . '/../../Generator/XSD/PO.xsd';
        $this->destination = __DIR__ . '/../../Temp/Generated/DTO';
        $this->destinationNS = 'WsSys\DtoGeneratorBundle\Tests\Temp\Generated\DTO';
        
        $this->generator = new XsdToDtoGenerator();
        $this->generator->setSkeletonDirs($this->getSkeletonDirs());
        parent::setUp();
    }
    
    
    public function tearDown() 
    {
        parent::tearDown();
    }
    
    /**
     * @expectedException WsSys\DtoGeneratorBundle\Exception\InvalidArgumentException
     * @expectedExceptionMessage Invalid argument or argument 'Destination' not provided.
     */
    public function testGenerateThrowsAnExceptionWhenDestinationDirIsNotProvided()
    {
        $this->generator->setSource($this->source)
                ->setDestinationNamespace($this->destinationNS);
        $this->generator->generate();
    }
    
    /**
     * @expectedException WsSys\DtoGeneratorBundle\Exception\InvalidArgumentException
     * @expectedExceptionMessage Invalid argument or argument 'Source' not provided.
     */
    public function testGenerateThrowsAnExceptionWhenSourceIsNotProvided()
    {
        $this->generator->setDestinationNamespace($this->destinationNS)
                ->setDestination($this->destination);
        $this->generator->generate();
    }
    
    /**
     * @expectedException WsSys\DtoGeneratorBundle\Exception\InvalidArgumentException
     * @expectedExceptionMessage Invalid argument or argument 'DestinationNamespace' not provided.
     */
    public function testGenerateThrowsAnExceptionWhenDestinationNSIsNotProvided()
    {
        $this->generator->setSource($this->source)
                ->setDestination($this->destination);
        $this->generator->generate();
    }
    
    
    public function testGenerateCreatesDTOForTheFirstElement()
    {
        $this->generator->setSource($this->source)
                ->setDestination($this->destination)
                ->setDestinationNamespace($this->destinationNS);
        
        $this->generator->generate();
        $this->assertFileExists($this->destination . '/ClientOrder.php');
        $class = '\\' . $this->destinationNS . '\\ClientOrder'; 
        $clientOrder = new $class();
        $this->assertTrue(method_exists($clientOrder, 'isInternal'));
    }
    
    /**
     * Sets the Skelaton Dirs
     * 
     * @param \WsSys\DtoGeneratorBundle\Tests\Generator\BundleInterface $bundle
     * @return string
     */
    protected function getSkeletonDirs()
    {
        $skeletonDirs = array();
        $skeletonDirs[] = __DIR__.'/../../../Resources/skeleton';
        return $skeletonDirs;
    }
}