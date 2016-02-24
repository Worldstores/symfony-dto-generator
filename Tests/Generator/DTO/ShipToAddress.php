<?php
/**
 * DTO ShipToAddress
 */
namespace WsSys\DtoGeneratorBundle\Tests\Generator\DTO;

use JMS\Serializer\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ShipToAddress
 * 
 * @Annotation\ExclusionPolicy("none")
 * @Annotation\XmlRoot("shipToAddress")
 */
class ShipToAddress
{
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("companyName")
     * @Annotation\XmlElement(cdata=false)
     */
    private $companyName;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("address1")
     * @Annotation\XmlElement(cdata=false)
     */
    private $address1;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("address2")
     * @Annotation\XmlElement(cdata=false)
     */
    private $address2;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("city")
     * @Annotation\XmlElement(cdata=false)
     */
    private $city;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("zip")
     * @Annotation\XmlElement(cdata=false)
     */
    private $zip;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("state")
     * @Annotation\XmlElement(cdata=false)
     */
    private $state;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("country")
     * @Annotation\XmlElement(cdata=false)
     */
    private $country;
    
        
    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return ShipToAddress
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }
    
    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return ShipToAddress
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }
    
    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return ShipToAddress
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }
    
    /**
     * Set city
     *
     * @param string $city
     *
     * @return ShipToAddress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }
    
    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return ShipToAddress
     */
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
    {
        return $this->zip;
    }
    
    /**
     * Set state
     *
     * @param string $state
     *
     * @return ShipToAddress
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
    
    /**
     * Set country
     *
     * @param string $country
     *
     * @return ShipToAddress
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }
    
        
    
}