<?php

/**
 * Exception for when an unexpected error occurs during the registration of a service provider.
 *
 * Thrown to signal that an exception was encountered while attempting to register a service provider,
 * potentially due to issues with the provider's constructor or initialization logic. This exception
 * helps identify problems that prevent a service provider from being successfully registered.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceProviderRegistrationException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("An unexpected exception was thrown while registering the service provider $class, check the inner exception.", $previous);
        $this->code = 1417;
    }
}