<?php

/**
 * Exception for when an alias class is not derived from the service class it's supposed to represent.
 *
 * This exception is thrown to indicate a logical inconsistency where an alias class does not have the
 * correct inheritance relationship with the service class it is intended to represent, either not being
 * a subclass or not implementing the expected interface.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class AliasClassNotDerivedException extends ServiceManagementException
{
    public function __construct(string $class, string $alias, ?Throwable $previous = null)
    {
        parent::__construct("The alias class $alias and the service class $class are not derived from each other.", $previous);
        $this->code = 1402;
    }
}