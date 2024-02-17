<?php

/**
 * Exception for when a service provider has not been registered.
 *
 * This exception is thrown when an operation is attempted on a service provider that has not been
 * registered within the service management system. It ensures that providers are properly registered
 * before they are used, maintaining system integrity.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceProviderNotRegisteredException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The service provider $class has not been registered.", $previous);
        $this->code = 1416;
    }
}