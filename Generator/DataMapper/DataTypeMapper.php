<?php

namespace WsSys\DtoGeneratorBundle\Generator\DataMapper;

/**
 * Mapping of Data Types between DTO/XSD or Other types
 */
class DataTypeMapper
{
    /**
     * List of mappings
     * 
     * @var array 
     */
    protected static $xsdToDtoMapping = array(
        'xs:string' => 'string',
        'xs:date' => 'DateTime',
        'xs:datetime' => 'DateTime',
        'xs:integer' => 'integer',
        'xs:decimal' => 'double',
        'xs:positiveInteger' => 'integer'
        );
    
    /**
     * Maps Data Type from Xsd to Dto
     * 
     * @param string $xsdType
     * 
     * @return string
     */
    public static function XsdToDto($xsdType)
    {
        if (array_key_exists($xsdType, self::$xsdToDtoMapping)) {
            return self::$xsdToDtoMapping[$xsdType];
        }
        return 'Unknown';
    }
}