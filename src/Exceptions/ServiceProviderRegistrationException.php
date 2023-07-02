<?php

namespace CommonPHP\ServiceManagement\Exceptions;

use Exception;
use Throwable;

/**
 * Exception thrown when a unexpected exception occurs during service provider registration
 */
class ServiceProviderRegistrationException extends Exception
{
    /**
     * @param string $class The class of the service provider that is already registered.
     * @param int $code The error code (default: 0).
     * @param Throwable|null $previous The previous throwable used for chaining exceptions (default: null).
     */
    public function __construct(string $class, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("An unexpected exception was thrown while registering the service provider $class, check the inner exception.", $code, $previous);
    }
}