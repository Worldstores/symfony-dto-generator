# Symfony DTO Generator
This bundle is to save you time required to map and create DTO and serialise/deserialise XML and JSON structure. It will generate the DTO Classes for you using JMS serialiser notations and will setup a basic Behat feature to test your DTO.

## Disclaimer
This bundle is still in development.

## Requirement
You need XSD/Json schema for your data structure.


## What does the bundle do?

Consider the following XML:

```xml
<xs:schema attributeFormDefault="unqualified" elementFormDefault="qualified" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <xs:element name="CATALOG">
    <xs:complexType>
      <xs:sequence>
        <xs:element name="CD" maxOccurs="unbounded" minOccurs="0">
          <xs:complexType>
            <xs:sequence>
              <xs:element type="xs:string" name="TITLE"/>
              <xs:element type="xs:string" name="ARTIST"/>
              <xs:element type="xs:string" name="COUNTRY"/>
              <xs:element type="xs:string" name="COMPANY"/>
              <xs:element type="xs:float" name="PRICE"/>
              <xs:element type="xs:short" name="YEAR"/>
            </xs:sequence>
          </xs:complexType>
        </xs:element>
      </xs:sequence>
    </xs:complexType>
  </xs:element>
</xs:schema>
```

The bundle will generate the following DTO Classes

```php
<?php
/**
 * DTO CATALOG
 */
namespace AppBundle\Dto;

use JMS\Serializer\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CATALOG
 * 
 * @Annotation\ExclusionPolicy("none")
 * @Annotation\XmlRoot("CATALOG")
 */
class CATALOG
{
    /**
     * @var AppBundle\Dto\CD
     * @Annotation\Type("AppBundle\Dto\CD")
     * @Annotation\SerializedName("CD")
     * @Annotation\XmlElement(cdata=false)
     */
    private $CD;

    /**
     * Set CD
     *
     * @param AppBundle\Dto\CD $CD
     *
     * @return CATALOG
     */
    public function setCD($CD)
    {
        $this->CD = $CD;

        return $this;
    }
                    
    /**
     * Get CD
     *
     * @return AppBundle\Dto\CD
     */
    public function getCD()
    {
        return $this->CD;
    }
}
```

```php
<?php
/**
 * DTO CD
 */
namespace AppBundle\Dto;

use JMS\Serializer\Annotation;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * CD
 * 
 * @Annotation\ExclusionPolicy("none")
 * @Annotation\XmlRoot("CD")
 */
class CD
{
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("TITLE")
     * @Annotation\XmlElement(cdata=false)
     */
    private $TITLE;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("ARTIST")
     * @Annotation\XmlElement(cdata=false)
     */
    private $ARTIST;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("COUNTRY")
     * @Annotation\XmlElement(cdata=false)
     */
    private $COUNTRY;
    
    /**
     * @var string
     * @Annotation\Type("string")
     * @Annotation\SerializedName("COMPANY")
     * @Annotation\XmlElement(cdata=false)
     */
    private $COMPANY;
    
    /**
     * @var Unknown
     * @Annotation\Type("Unknown")
     * @Annotation\SerializedName("PRICE")
     * @Annotation\XmlElement(cdata=false)
     */
    private $PRICE;
    
    /**
     * @var Unknown
     * @Annotation\Type("Unknown")
     * @Annotation\SerializedName("YEAR")
     * @Annotation\XmlElement(cdata=false)
     */
    private $YEAR;
    

    /**
     * Set TITLE
     *
     * @param string $TITLE
     *
     * @return CD
     */
    public function setTITLE($TITLE)
    {
        $this->TITLE = $TITLE;

        return $this;
    }
                    
    /**
     * Get TITLE
     *
     * @return string
     */
    public function getTITLE()
    {
        return $this->TITLE;
    }
    /**
     * Set ARTIST
     *
     * @param string $ARTIST
     *
     * @return CD
     */
    public function setARTIST($ARTIST)
    {
        $this->ARTIST = $ARTIST;

        return $this;
    }
                    
    /**
     * Get ARTIST
     *
     * @return string
     */
    public function getARTIST()
    {
        return $this->ARTIST;
    }
    /**
     * Set COUNTRY
     *
     * @param string $COUNTRY
     *
     * @return CD
     */
    public function setCOUNTRY($COUNTRY)
    {
        $this->COUNTRY = $COUNTRY;

        return $this;
    }
                    
    /**
     * Get COUNTRY
     *
     * @return string
     */
    public function getCOUNTRY()
    {
        return $this->COUNTRY;
    }
    /**
     * Set COMPANY
     *
     * @param string $COMPANY
     *
     * @return CD
     */
    public function setCOMPANY($COMPANY)
    {
        $this->COMPANY = $COMPANY;

        return $this;
    }
                    
    /**
     * Get COMPANY
     *
     * @return string
     */
    public function getCOMPANY()
    {
        return $this->COMPANY;
    }
    /**
     * Set PRICE
     *
     * @param Unknown $PRICE
     *
     * @return CD
     */
    public function setPRICE($PRICE)
    {
        $this->PRICE = $PRICE;

        return $this;
    }
                    
    /**
     * Get PRICE
     *
     * @return Unknown
     */
    public function getPRICE()
    {
        return $this->PRICE;
    }
    /**
     * Set YEAR
     *
     * @param Unknown $YEAR
     *
     * @return CD
     */
    public function setYEAR($YEAR)
    {
        $this->YEAR = $YEAR;

        return $this;
    }
                    
    /**
     * Get YEAR
     *
     * @return Unknown
     */
    public function getYEAR()
    {
        return $this->YEAR;
    }
 
}
```


## Installation

You can install the bundle using composer

```bash
composer require worldstores/dto-generator-bundle dev-master
```

then in `AppKernel.php` file, add the bundle to dev bundles array:

```php
if (in_array($this->getEnvironment(), array('dev', 'test'), true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new WsSys\DtoGeneratorBundle\WsSysDtoGeneratorBundle();
        }
```


## Example

1) Add the following XSD to `Resources/xsd/dto_test.xsd`

```xml
<xs:schema attributeFormDefault="unqualified" elementFormDefault="qualified" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <xs:element name="note">
        <xs:complexType>
            <xs:sequence>
                <xs:element type="xs:string" name="to"/>
                <xs:element type="xs:string" name="from"/>
                <xs:element type="xs:string" name="heading"/>
                <xs:element type="xs:string" name="body"/>
            </xs:sequence>
        </xs:complexType>
    </xs:element>
</xs:schema>
```

2) Run the following command:

```php
php app/console ws:generator:generate:dto \
    app/Resources/xsd/dto_test.xsd \
    src/AppBundle/Dto/ \
    AppBundle\\Dto \
    xsd \
    0 \
    AppBundle
```
3) Make sure that you have the folder `Dto` inside AppBundle

It will generate a class named `Note.php`


## Command Arguments

> php app/console ws:generator:generate:dto *SourceFile* *DestinationClass* *Namespace* *type* *generateController?* *BundleName*
 
 

| Argument | Description |
| --- | --- |
| SourceFile | XSD or Json schema file. |
| DestinationClass | the Dto Class location including bundleName folder |
| Namespace | Namespace of Dto. |
| FileType | `xsd` or `json` | 
| Generate Controller? | 1 or 0 |
| Bundle Name (optional) | Bundle name that will have this DTO |


Example: 

```php
php app/console ws:generator:generate:dto \
    app/Resources/xsd/dto_test.xsd \
    src/AppBundle/Dto/ \
    AppBundle\\Dto \
    xsd \
    0 \
    AppBundle
```