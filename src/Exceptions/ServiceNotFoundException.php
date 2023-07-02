<?php

namespace CommonPHP\ServiceManagement\Exceptions;

use Exception;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

/**
 * Exception thrown when a requested service is not found in the container.
 */
class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface
{
    /**
     * @param string $class The class of the requested service that was not found.
     * @param int $code The error code (default: 0).
     * @param Throwable|null $previous  The previous throwable used for chaining exceptions (default: null).
     */
    public function __construct(string $class, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("The requested service $class was not found in the container.", $code, $previous);
    }
}