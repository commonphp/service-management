<?php

/**
 * Exception for when a namespace is already registered within the service management system.
 *
 * This exception is thrown to prevent the duplication of namespace registrations, ensuring that each
 * namespace is uniquely identified and associated with its respective services and providers.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class NamespaceAlreadyRegisteredException extends ServiceManagementException
{
    public function __construct(string $namespace, ?Throwable $previous = null)
    {
        parent::__construct("The namespace $namespace is already registered.", $previous);
        $this->code = 1406;
    }
}