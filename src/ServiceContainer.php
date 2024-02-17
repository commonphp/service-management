<?php

/**
 * Provides read-only access to services managed by the ServiceManager.
 *
 * This final class implements the PSR-11 ContainerInterface, offering a standardized mechanism for retrieving
 * services within an application. It is designed for use during runtime, with the ServiceManager handling
 * the actual service registration and configuration during bootstrapping/startup. By adhering to PSR-11, it
 * ensures interoperability with other compliant containers.
 *
 * @package CommonPHP\ServiceManagement
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @see https://www.php-fig.org/psr/psr-11/ PSR-11: Container Interface
 */

namespace CommonPHP\ServiceManagement;

use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use Psr\Container\ContainerInterface;

/**
 * ServiceContainer Class
 *
 * This class implements the PSR-11 ContainerInterface and serves as a read-only access point for services
 * managed by the ServiceManager. It delegates the actual retrieval and checking of services to the ServiceManager.
 */
final class ServiceContainer implements ContainerInterface
{
    /**
     * @var ServiceManagerContract The service manager instance.
     */
    private ServiceManagerContract $manager;

    /**
     * Initializes the service container with a service manager.
     *
     * @param ServiceManagerContract $manager The service manager.
     */
    public function __construct(ServiceManagerContract $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Retrieves a service by its identifier.
     * Delegates the retrieval of the service to the ServiceManager.
     *
     * @template T
     * @param class-string<T> $id The identifier of the service to retrieve.
     * @return T
     */
    public function get(string $id)
    {
        return $this->manager->get($id);
    }

    /**
     * Checks if a service exists.
     * Delegates the checking of the service to the ServiceManager.
     *
     * @param class-string $id The identifier of the service to check.
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->manager->has($id);
    }
}