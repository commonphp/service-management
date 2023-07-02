<?php

/**
 * ServiceContainer class
 *
 * The ServiceContainer is the read-only point of access for ServiceManager.
 * ServiceManager should be used by bootstrapping/startup, while the ServiceContainer should be used during execution.
 *
 * This class should be PSR-11 compatible, as the exceptions thrown by methods adhere to PSR-11 guidelines.
 *
 * @package    CommonPHP\ServiceManagement
 * @author     Timothy McClatchey <timothy@commonphp.org>
 * @copyright  2023 CommonPHP.org
 * @license    http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement;

use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException;
use CommonPHP\ServiceManagement\Exceptions\ServiceResolutionException;
use Psr\Container\ContainerInterface;

/**
 * ServiceContainer Class
 *
 * This class implements the PSR-11 ContainerInterface and serves as a read-only access point for services
 * managed by the ServiceManager. It delegates the actual retrieval and checking of services to the ServiceManager.
 */
final class ServiceContainer implements ContainerInterface
{
    private ServiceManagerContract $manager;

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
     * @throws ServiceNotFoundException
     * @throws ServiceResolutionException
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