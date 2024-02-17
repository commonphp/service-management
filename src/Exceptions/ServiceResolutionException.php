<?php

/**
 * Exception for when a service cannot be resolved.
 *
 * This exception is used within the service management system to indicate that a service could not be
 * instantiated or resolved. This may occur for a variety of reasons, such as configuration errors,
 * missing dependencies, or incorrect service definitions.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Exceptions
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Exceptions;

use Psr\Container\ContainerExceptionInterface;
use Throwable;

class ServiceResolutionException extends ServiceManagementException implements ContainerExceptionInterface
{
    public function __construct(string $class, ?Throwable $previous = null)
    {
        parent::__construct("An error occurred while resolving the service $class.", $previous);
        $this->code = 1418;
    }
}