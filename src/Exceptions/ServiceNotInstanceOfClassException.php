<?php

/**
 * Exception for when a service instance does not match the expected class or interface type.
 *
 * This exception is thrown to address type mismatches between a requested service and its registered
 * instance, ensuring that services conform to their declared types or interfaces for safe usage.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceNotInstanceOfClassException extends ServiceManagementException
{
    public function __construct(string $class, string $service, ?Throwable $previous = null)
    {
        parent::__construct("The service object $service is not an instance or a subclass of the service class $class.", $previous);
        $this->code = 1412;
    }
}