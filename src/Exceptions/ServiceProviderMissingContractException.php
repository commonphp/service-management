<?php

/**
 * Exception for when a service provider does not implement the required contract.
 *
 * This exception is thrown when a service provider is registered but does not implement the
 * ServiceProviderContract, ensuring that all service providers adhere to a consistent interface and
 * can be managed uniformly by the service management system.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ServiceProviderMissingContractException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The service provider $class does not implement ServiceProviderContract.", $previous);
        $this->code = 1414;
    }
}