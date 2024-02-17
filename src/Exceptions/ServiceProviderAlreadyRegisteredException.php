<?php

/**
 * Exception for when a service provider is already registered within the service management system.
 *
 * Thrown to avoid duplication of service provider registrations, ensuring that each provider is uniquely
 * registered and managed within the system's provider registry.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceProviderAlreadyRegisteredException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The service provider $class is already registered.", $previous);
        $this->code = 1413;
    }
}