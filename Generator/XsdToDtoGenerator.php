<?php

namespace WsSys\DtoGeneratorBundle\Generator;

use WsSys\DtoGeneratorBundle\Generator\Parser\XsdParser;

/**
 * Generate the Dtos from Xsd
 */
class XsdToDtoGenerator extends AbstractGenerator
{
    /**
     * Generates the DTOs
     * 
     * @param boolean $forceOverwrite
     * @throws InvalidArgumentException
     */
    public function generate($forceOverwrite = true)
    {
        $this->validateInput();
        $source = $this->getSource();
        $parser = new XsdParser();
        $parser->parse($source);
        
        $firstElement = $parser->getFirstElementWithChildren();
        $this->genereateDTOClasses($firstElement, $forceOverwrite);
    }
}