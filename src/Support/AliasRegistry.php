<?php

/**
 * Manages alias mappings for service classes within the service management framework.
 *
 * This class provides a mechanism for registering and resolving aliases to service classes, facilitating flexible
 * service referencing and abstraction. It supports checking for the existence of aliases, retrieving the service
 * class for a given alias, and registering new aliases with validation to ensure that aliases and service classes
 * are properly defined and related.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Support
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use CommonPHP\ServiceManagement\Exceptions\AliasAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\AliasClassNotDerivedException;
use CommonPHP\ServiceManagement\Exceptions\AliasClassNotFoundException;
use CommonPHP\ServiceManagement\Exceptions\AliasNotRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException;

final class AliasRegistry
{
    /** @var ServiceManagerContract The service manager instance for checking service existence. */
    private ServiceManagerContract $manager;

    /** @var class-string[] Registered aliases mapped to their corresponding service classes. */
    private array $aliases = [];

    /**
     * Initializes the alias registry with a reference to the service manager.
     *
     * @param ServiceManagerContract $manager The service manager instance.
     */
    public function __construct(ServiceManagerContract $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Check if an alias exists.
     *
     * @param class-string $className The name of the class
     * @return bool
     */
    public function has(string $className): bool
    {
        return array_key_exists($className, $this->aliases);
    }

    /**
     * Get the service class for a given alias.
     *
     * @param class-string $className The name of the class
     * @return class-string
     * @throws AliasNotRegisteredException
     */
    public function get(string $className): string
    {
        if (!$this->has($className)) {
            throw new AliasNotRegisteredException($className);
        }
        return $this->aliases[$className];
    }

    /**
     * Register a service class alias.
     *
     * @param class-string $aliasClass The alias class
     * @param class-string $serviceClass The service class
     * @throws AliasAlreadyRegisteredException
     * @throws ServiceNotFoundException
     * @throws AliasClassNotFoundException
     * @throws AliasClassNotDerivedException
     */
    public function register(string $aliasClass, string $serviceClass): void
    {
        // Make sure the alias isn't already set
        if ($this->has($aliasClass)) {
            throw new AliasAlreadyRegisteredException($aliasClass, $serviceClass, $this->aliases[$aliasClass]);
        }

        // Make sure the service has been registered
        if (!$this->manager->has($serviceClass)) {
            throw new ServiceNotFoundException($serviceClass);
        }

        // Make sure the alias class exists as a class or interface
        if (!class_exists($aliasClass) && !interface_exists($aliasClass)) {
            throw new AliasClassNotFoundException($aliasClass);
        }

        // Make sure that the alias class is a subclass of service class, or vice versa
        if (!is_subclass_of($aliasClass, $serviceClass) && !is_subclass_of($serviceClass, $aliasClass)) {
            throw new AliasClassNotDerivedException($aliasClass, $serviceClass);
        }

        // If no validation issues, register the alias
        $this->aliases[$aliasClass] = $serviceClass;
    }
}