<?php

/**
 * Exception for when a requested service cannot be found within the service management system.
 *
 * Thrown when an attempt is made to access a service that is not registered or otherwise unavailable,
 * ensuring that service dependencies are correctly registered and accessible before use.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class ServiceNotFoundException extends ServiceManagementException implements NotFoundExceptionInterface
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The requested service $class was not found in the container.", $previous);
        $this->code = 1411;
    }
}