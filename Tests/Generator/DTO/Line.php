<?php
/**
 * DTO Line
 */
namespace WsSys\DtoGeneratorBundle\Tests\Generator\DTO;

use JMS\Serializer\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Line
 * 
 * @Annotation\ExclusionPolicy("none")
 * @Annotation\XmlRoot("line")
 */
class Line
{
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("lineId")
     * @Annotation\XmlElement(cdata=false)
     */
    private $lineId;
    
    /**
     * @var integer
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("lineNumber")
     * @Annotation\XmlElement(cdata=false)
     */
    private $lineNumber;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("productName")
     * @Annotation\XmlElement(cdata=false)
     */
    private $productName;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("altSku")
     * @Annotation\XmlElement(cdata=false)
     */
    private $altSku;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("sku")
     * @Annotation\XmlElement(cdata=false)
     */
    private $sku;
    
    /**
     * @var integer
     * @Annotation\Type("integer")
     * @Annotation\SerializedName("qty")
     * @Annotation\XmlElement(cdata=false)
     */
    private $qty;
    
        
    /**
     * Set lineId
     *
     * @param string $lineId
     *
     * @return Line
     */
    public function setLineId($lineId)
    {
        $this->lineId = $lineId;

        return $this;
    }

    /**
     * Get lineId
     *
     * @return string
     */
    public function getLineId()
    {
        return $this->lineId;
    }
    
    /**
     * Set lineNumber
     *
     * @param integer $lineNumber
     *
     * @return Line
     */
    public function setLineNumber($lineNumber)
    {
        $this->lineNumber = $lineNumber;

        return $this;
    }

    /**
     * Get lineNumber
     *
     * @return integer
     */
    public function getLineNumber()
    {
        return $this->lineNumber;
    }
    
    /**
     * Set productName
     *
     * @param string $productName
     *
     * @return Line
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * Get productName
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }
    
    /**
     * Set altSku
     *
     * @param string $altSku
     *
     * @return Line
     */
    public function setAltSku($altSku)
    {
        $this->altSku = $altSku;

        return $this;
    }

    /**
     * Get altSku
     *
     * @return string
     */
    public function getAltSku()
    {
        return $this->altSku;
    }
    
    /**
     * Set sku
     *
     * @param string $sku
     *
     * @return Line
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }
    
    /**
     * Set qty
     *
     * @param integer $qty
     *
     * @return Line
     */
    public function setQty($qty)
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Get qty
     *
     * @return integer
     */
    public function getQty()
    {
        return $this->qty;
    }
    
        
    
}