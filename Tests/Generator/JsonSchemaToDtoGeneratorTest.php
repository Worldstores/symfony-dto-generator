<?php

namespace WsSys\DtoGeneratorBundle\Tests\Generator;

use WsSys\DtoGeneratorBundle\Generator\JsonSchemaToDtoGenerator;
use org\bovigo\vfs\vfsStream;

class JsonScehmaToDtoGeneratorTest extends \PhpUnit_Framework_TestCase
{
    
    private $generator;
    
    private $source;
    
    private $destination;
    
    private $destinationNS;
    
    /**
     * @type  vfsStreamDirectory
     */
    protected $root;
    
    public function setUp() 
    {
        $this->source = __DIR__ . '/JsonSchema/robot.schema.json';
        $this->destinationNS = 'WsSys\DtoGeneratorBundle\Tests\Temp\Generated\DTO';
        $this->generator = new JsonSchemaToDtoGenerator();
        $this->generator->setSkeletonDirs($this->getSkeletonDirs());
        
        $this->root = vfsStream::setup('dtoTest');
        $this->createDestinationDir(vfsStream::url('dtoTest'));
        
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
        
        $firstElement = $this->generator->generate();
        $this->assertEquals('RobotMe', $firstElement);
        $this->assertFileExists($this->destination . '/RobotMe.php');
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
        $skeletonDirs[] = __DIR__.'/../../Resources/skeleton';
        return $skeletonDirs;
    }
    
    /**
     * creates the directory using vfsStream
     *
     * @param  string  $directory
     */
    public function createDestinationDir($directory)
    {
        $this->destination = $directory . DIRECTORY_SEPARATOR . 'DTO';
        if (file_exists($this->directory) === false) {
            mkdir($this->destination, 0700, true);
        }
    }
}