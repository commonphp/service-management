<?php

/**
 * Descriptive exception when an alias is already registered within the service management system.
 *
 * This exception is thrown when an attempt is made to register an alias that is already in use by another service.
 * It ensures the uniqueness of aliases across the service management framework, preventing conflicts and ambiguity
 * in service resolution.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class AliasAlreadyRegisteredException extends ServiceManagementException
{
    public function __construct(string $class, string $alias, string $service, ?Throwable $previous = null)
    {
        parent::__construct("The alias $alias is already registered for the service $service, it can't be used for the service $class.", $previous);
        $this->code = 1401;
    }
}