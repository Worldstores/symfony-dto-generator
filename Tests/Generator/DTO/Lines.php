<?php
/**
 * DTO Lines
 */
namespace WsSys\DtoGeneratorBundle\Tests\Generator\DTO;

use JMS\Serializer\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Lines
 * 
 * @Annotation\ExclusionPolicy("none")
 * @Annotation\XmlRoot("lines")
 */
class Lines
{
    /**
     * @var WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Line
     * @Annotation\Type("WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Line")
     * @Annotation\SerializedName("line")
     * @Annotation\XmlElement(cdata=false)
     */
    private $line;
    
        
    /**
     * Set line
     *
     * @param WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Line $line
     *
     * @return Lines
     */
    public function setLine($line)
    {
        $this->line = $line;

        return $this;
    }

    /**
     * Get line
     *
     * @return WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Line
     */
    public function getLine()
    {
        return $this->line;
    }
    
        
    
}