<?php

/**
 * Exception for when no service provider is available for a requested service class.
 *
 * This exception is thrown by the service management system when a request is made for a service class
 * and no registered service provider is capable of handling that request, indicating a gap in the service
 * provider registrations or a misconfiguration.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class NoProviderForServiceException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("There were no service providers available that supports the class $class.", $previous);
        $this->code = 1408;
    }
}