<?php

/**
 * Exception for when a specified class or interface is not defined.
 *
 * Thrown when the service management system expects a class or interface that does not exist in the
 * current context. This exception helps identify issues related to missing dependencies or incorrect
 * service configurations.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class ClassOrInterfaceNotDefinedException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The class or interface $class is not defined.", $previous);
        $this->code = 1405;
    }
}