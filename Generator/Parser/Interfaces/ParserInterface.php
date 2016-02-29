<?php

namespace WsSys\DtoGeneratorBundle\Generator\Parser\Interfaces;


/**
 * Interface Parsers
 */
interface ParserInterface
{
    /**
     * Source to be parsed
     * 
     * @param string $source
     */
    public function parse($source);
    
    /**
     * Return First Element
     */
    public function getFirstElementWithChildren();
}
