<?php

namespace CommonPHP\ServiceManagement\Exceptions;


use Exception;
use Throwable;

/**
 * Exception thrown when a class or interface is not defined.
 */
class ClassOrInterfaceNotDefinedException extends Exception
{
    /**
     * ClassNotDefinedException constructor.
     *
     * @param string $class The class that is not defined.
     * @param int $code The error code (default: 0).
     * @param Throwable|null $previous The previous throwable used for chaining exceptions (default: null).
     */
    public function __construct(string $class, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("The class or interface $class is not defined.", $code, $previous);
    }
}