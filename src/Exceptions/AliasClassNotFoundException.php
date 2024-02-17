<?php

/**
 * Exception for when an alias class does not exist.
 *
 * Thrown when the system attempts to use an alias for a class that cannot be found. This ensures that
 * alias mappings are valid and point to actual class definitions, preventing runtime errors due to
 * missing classes.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class AliasClassNotFoundException extends ServiceManagementException
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("The alias class for service $class was not found.", $previous);
        $this->code = 1403;
    }
}