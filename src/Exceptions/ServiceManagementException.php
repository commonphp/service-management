<?php

/**
 * Base exception class for all service management related exceptions.
 *
 * This class extends the base PHP Exception class, providing a common base for all exceptions thrown
 * by the service management framework. It allows for consistent handling of exception cases across the
 * system and supports chaining with previous exceptions.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Exception;
use Throwable;

class ServiceManagementException extends Exception
{
    public function __construct(string $message = "", Throwable $previous = null)
    {
        parent::__construct($message, 1400, $previous);
    }
}