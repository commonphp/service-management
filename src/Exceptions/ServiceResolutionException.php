<?php

namespace CommonPHP\ServiceManagement\Exceptions;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Throwable;

/**
 * Exception thrown when an error occurs during the resolution of a service.
 */
class ServiceResolutionException extends Exception implements ContainerExceptionInterface
{
    /**
     * @param string $class The class of the service where resolution failed.
     * @param int $code The error code (default: 0).
     * @param Throwable|null $previous  The previous throwable used for chaining exceptions (default: null).
     */
    public function __construct(string $class, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("An error occurred while resolving the service $class.", $code, $previous);
    }
}