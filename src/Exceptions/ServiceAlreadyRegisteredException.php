<?php

/**
 * Exception for when a service is already registered within the service management system.
 *
 * Thrown to prevent duplicate registrations of the same service, ensuring that each service is uniquely
 * identifiable and preventing conflicts within the service registry.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceAlreadyRegisteredException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The service $class is already registered or is handled by a service provider.", $previous);
        $this->code = 1409;
    }
}