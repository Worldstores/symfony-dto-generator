<?php

namespace WsSys\DtoGeneratorBundle\Generator;

use WsSys\DtoGeneratorBundle\Generator\Parser\JsonSchemaParser;

/**
 * Generate the Dtos from Json
 */
class JsonSchemaToDtoGenerator extends AbstractGenerator
{
    /**
     * Generates the DTOs
     * 
     * @throws InvalidArgumentException
     * @return string
     */
    public function generate($forceOverwrite = true)
    {
        $this->validateInput();
        $parser = new JsonSchemaParser();
        $parser->parse($this->getSource());
        $firstElement = $parser->getFirstElementWithChildren();
        $this->genereateDTOClasses($firstElement, $forceOverwrite);
        
        return $firstElement->getUcfirstName();
    }
}