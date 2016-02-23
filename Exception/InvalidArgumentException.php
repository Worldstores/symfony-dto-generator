<?php

namespace WsSys\DtoGeneratorBundle\Exception;

/**
 * Class InvalidArgumentException
 * 
 * @package DtoGeneratorBundle
 */
class InvalidArgumentException extends \LogicException
{
    /**
     * @param string $argument
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($argument, $code = 0, \Exception $previous = null) 
    {
        $message = sprintf('Invalid argument or argument \'%s\' not provided.', $argument); 
        parent::__construct($message, $code, $previous);
    }
}