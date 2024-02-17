<?php

/**
 * Exception for when an attempt is made to access an alias that has not been registered.
 *
 * This exception is thrown to indicate that the requested alias does not exist in the alias registry,
 * preventing undefined behavior by ensuring that only registered aliases are used for service resolution.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class AliasNotRegisteredException extends ServiceManagementException
{
    public function __construct(string $alias, ?Throwable $previous = null)
    {
        parent::__construct("The alias $alias has not been registered with a class.", $previous);
        $this->code = 1404;
    }
}