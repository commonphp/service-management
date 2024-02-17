<?php

/**
 * Exception for when a provided namespace is not valid according to PHP namespace rules.
 *
 * Thrown to indicate that a namespace registration attempt has failed due to the provided namespace
 * not adhering to the syntactical rules of PHP namespaces. Ensures that only valid namespaces are
 * registered and used within the system.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Throwable;

class NamespaceInvalidException extends ServiceManagementException
{
    public function __construct(string $namespace, ?Throwable $previous = null)
    {
        parent::__construct("The namespace $namespace is not a valid PHP namespace.", $previous);
        $this->code = 1407;
    }
}