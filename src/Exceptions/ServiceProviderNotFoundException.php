<?php

/**
 * Exception for when a service provider class cannot be found.
 *
 * Thrown when the system is unable to locate the class file for a service provider, typically indicating
 * an issue with the class loader configuration or an incorrect namespace. It helps diagnose and prevent
 * configuration errors related to service provider registration.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceProviderNotFoundException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The service provider class $class was not found.", $previous);
        $this->code = 1415;
    }
}