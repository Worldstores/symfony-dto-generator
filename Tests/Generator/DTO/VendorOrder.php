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
     * @Annotation\SerializedName("vendorOrderId")
     * @Annotation\XmlElement(cdata=false)
     */
    private $vendorOrderId;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("poNumber")
     * @Annotation\XmlElement(cdata=false)
     */
    private $poNumber;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("distributionCentre")
     * @Annotation\XmlElement(cdata=false)
     */
    private $distributionCentre;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("catalogId")
     * @Annotation\XmlElement(cdata=false)
     */
    private $catalogId;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("clientId")
     * @Annotation\XmlElement(cdata=false)
     */
    private $clientId;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("vendorId")
     * @Annotation\XmlElement(cdata=false)
     */
    private $vendorId;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("carrierName")
     * @Annotation\XmlElement(cdata=false)
     */
    private $carrierName;
    
    /**
     * @var DateTime
     * @Annotation\Type("DateTime")
     * @Annotation\SerializedName("shipDate")
     * @Annotation\XmlElement(cdata=false)
     */
    private $shipDate;
    
    /**
     * @var DateTime
     * @Annotation\Type("DateTime")
     * @Annotation\SerializedName("expectedDeliveryDate")
     * @Annotation\XmlElement(cdata=false)
     */
    private $expectedDeliveryDate;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("countryOfOrigin")
     * @Annotation\XmlElement(cdata=false)
     */
    private $countryOfOrigin;
    
    /**
     * @var WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipToAddress
     * @Annotation\Type("WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipToAddress")
     * @Annotation\SerializedName("shipToAddress")
     * @Annotation\XmlElement(cdata=false)
     */
    private $shipToAddress;
    
    /**
     * @var ShipFromAddress
     * @Annotation\Type("WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipFromAddress")
     * @Annotation\SerializedName("shipFromAddress")
     * @Annotation\XmlElement(cdata=false)
     */
    private $shipFromAddress;
    
    /**
     * @var WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Lines
     * @Annotation\Type("WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Lines")
     * @Annotation\SerializedName("lines")
     * @Annotation\XmlElement(cdata=false)
     */
    private $lines;
    
        /**
     * @var string 
     * @Annotation\Exclude()
     */
    private $token;
    
    /**
     * Set vendorOrderId
     *
     * @param string $vendorOrderId
     *
     * @return VendorOrder
     */
    public function setVendorOrderId($vendorOrderId)
    {
        $this->vendorOrderId = $vendorOrderId;

        return $this;
    }

    /**
     * Get vendorOrderId
     *
     * @return string
     */
    public function getVendorOrderId()
    {
        return $this->vendorOrderId;
    }
    
    /**
     * Set poNumber
     *
     * @param string $poNumber
     *
     * @return VendorOrder
     */
    public function setPoNumber($poNumber)
    {
        $this->poNumber = $poNumber;

        return $this;
    }

    /**
     * Get poNumber
     *
     * @return string
     */
    public function getPoNumber()
    {
        return $this->poNumber;
    }
    
    /**
     * Set distributionCentre
     *
     * @param string $distributionCentre
     *
     * @return VendorOrder
     */
    public function setDistributionCentre($distributionCentre)
    {
        $this->distributionCentre = $distributionCentre;

        return $this;
    }

    /**
     * Get distributionCentre
     *
     * @return string
     */
    public function getDistributionCentre()
    {
        return $this->distributionCentre;
    }
    
    /**
     * Set catalogId
     *
     * @param string $catalogId
     *
     * @return VendorOrder
     */
    public function setCatalogId($catalogId)
    {
        $this->catalogId = $catalogId;

        return $this;
    }

    /**
     * Get catalogId
     *
     * @return string
     */
    public function getCatalogId()
    {
        return $this->catalogId;
    }
    
    /**
     * Set clientId
     *
     * @param string $clientId
     *
     * @return VendorOrder
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;

        return $this;
    }

    /**
     * Get clientId
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    
    /**
     * Set vendorId
     *
     * @param string $vendorId
     *
     * @return VendorOrder
     */
    public function setVendorId($vendorId)
    {
        $this->vendorId = $vendorId;

        return $this;
    }

    /**
     * Get vendorId
     *
     * @return string
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }
    
    /**
     * Set carrierName
     *
     * @param string $carrierName
     *
     * @return VendorOrder
     */
    public function setCarrierName($carrierName)
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    /**
     * Get carrierName
     *
     * @return string
     */
    public function getCarrierName()
    {
        return $this->carrierName;
    }
    
    /**
     * Set shipDate
     *
     * @param DateTime $shipDate
     *
     * @return VendorOrder
     */
    public function setShipDate($shipDate)
    {
        $this->shipDate = $shipDate;

        return $this;
    }

    /**
     * Get shipDate
     *
     * @return DateTime
     */
    public function getShipDate()
    {
        return $this->shipDate;
    }
    
    /**
     * Set expectedDeliveryDate
     *
     * @param DateTime $expectedDeliveryDate
     *
     * @return VendorOrder
     */
    public function setExpectedDeliveryDate($expectedDeliveryDate)
    {
        $this->expectedDeliveryDate = $expectedDeliveryDate;

        return $this;
    }

    /**
     * Get expectedDeliveryDate
     *
     * @return DateTime
     */
    public function getExpectedDeliveryDate()
    {
        return $this->expectedDeliveryDate;
    }
    
    /**
     * Set countryOfOrigin
     *
     * @param string $countryOfOrigin
     *
     * @return VendorOrder
     */
    public function setCountryOfOrigin($countryOfOrigin)
    {
        $this->countryOfOrigin = $countryOfOrigin;

        return $this;
    }

    /**
     * Get countryOfOrigin
     *
     * @return string
     */
    public function getCountryOfOrigin()
    {
        return $this->countryOfOrigin;
    }
    
    /**
     * Set shipToAddress
     *
     * @param WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipToAddress $shipToAddress
     *
     * @return VendorOrder
     */
    public function setShipToAddress($shipToAddress)
    {
        $this->shipToAddress = $shipToAddress;

        return $this;
    }

    /**
     * Get shipToAddress
     *
     * @return WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipToAddress
     */
    public function getShipToAddress()
    {
        return $this->shipToAddress;
    }
    
    /**
     * Set shipFromAddress
     *
     * @param WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipFromAddress $shipFromAddress
     *
     * @return VendorOrder
     */
    public function setShipFromAddress($shipFromAddress)
    {
        $this->shipFromAddress = $shipFromAddress;

        return $this;
    }

    /**
     * Get shipFromAddress
     *
     * @return WsSys\DtoGeneratorBundle\Tests\Generator\DTO\ShipFromAddress
     */
    public function getShipFromAddress()
    {
        return $this->shipFromAddress;
    }
    
    /**
     * Set lines
     *
     * @param WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Lines $lines
     *
     * @return VendorOrder
     */
    public function setLines($lines)
    {
        $this->lines = $lines;

        return $this;
    }

    /**
     * Get lines
     *
     * @return WsSys\DtoGeneratorBundle\Tests\Generator\DTO\Lines
     */
    public function getLines()
    {
        return $this->lines;
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