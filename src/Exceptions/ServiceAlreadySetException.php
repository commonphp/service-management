<?php

/**
 * Exception for when a service has already been set and cannot be replaced or redefined.
 *
 * This exception is thrown when there is an attempt to override an existing service instance that
 * has already been explicitly set within the service management system, enforcing immutability for
 * manually set service instances.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceAlreadySetException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The service $class cannot be manually set because it's already been set.", $previous);
        $this->code = 1410;
    }
}