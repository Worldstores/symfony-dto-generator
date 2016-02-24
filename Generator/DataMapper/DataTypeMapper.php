<?php

namespace WsSys\DtoGeneratorBundle\Generator\DataMapper;

/**
 * Mapping of Data Types between DTO/XSD or Other types
 */
class DataTypeMapper
{
    
    /**
     * Maps Data Type from Xsd to Dto
     * @param string $xsdType
     * @return string
     */
    public static function XsdToDto($xsdType)
    {
        $mappings = array('xs:string' => 'string',
            'xs:date' => 'DateTime',
            'xs:datetime' => 'DateTime',
            'xs:integer' => 'integer', 
            'xs:decimal' => 'double',
            'xs:positiveInteger' => 'integer');
        
        if (array_key_exists($xsdType, $mappings)) {
            return $mappings[$xsdType];
        }
        return 'Unknown';
    }
}