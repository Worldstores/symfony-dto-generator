<?php
/**
 * DTO VendorOrder
 */
namespace WsSys\DtoGeneratorBundle\Tests\Generator\DTO;

use JMS\Serializer\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * VendorOrder
 * 
 * @Annotation\ExclusionPolicy("none")
 * @Annotation\XmlRoot("vendorOrder")
 */
class VendorOrder
{
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("")
     * @Annotation\XmlElement(cdata=)
     */
    private $;
    
       
    /**
     * @var string 
     * @Annotation\Exclude()
     */
    private $token;
    
    
    /**
     * Set 
     *
     * @param string $
     *
     * @return VendorOrder
     */
     public function set($)
    {
        $this-> = $;

        return $this;
    }

    /**
     * Get 
     *
     * @return string
     */
    public function get()
    {
        return $this->;
    }
        
    /**
     * Set token
     *
     * @param string $token
     *
     * @return VendorOrder
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
    }