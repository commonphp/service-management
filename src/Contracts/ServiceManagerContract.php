<?php

/**
 * Outlines the required functionality for service managers within the service management framework.
 *
 * This contract specifies methods for registering, setting, retrieving, and checking services by their class names,
 * serving as a foundation for any service manager implementation. It enables the creation of custom service manager
 * classes or mock classes for testing, ensuring compatibility with the service container and support classes.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Contracts
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Contracts;

interface ServiceManagerContract
{
    /**
     * Registers a service by its class name with specific parameters.
     *
     * @param string $className The class name of the service to register.
     * @param array $parameters The parameters to pass to the service's constructor.
     */
    public function register(string $className, array $parameters = []): void;


    /**
     * Explicitly sets a service by its class name with a specific instance.
     * This method is used when an instance of a service needs to be explicitly set,
     * instead of depending on the DependencyInjector to instantiate it when it's called.
     *
     * @param string $className The class name of the service to set.
     * @param object $instance The instance to set.
     * @param bool $autoRegister If set to true, the service will be auto registered if not already registered.
     */
    public function set(string $className, object $instance, bool $autoRegister = true): void;

    /**
     * @template T
     * Attempts to retrieve a service by its class name.
     * If the service does not exist, a ServiceNotFoundException will be thrown.
     *
     * @param class-string<T> $className The class name of the service to retrieve.
     * @param array $parameters The parameters to pass to the service's constructor.
     * @return T
     */
    public function get(string $className, array $parameters = []): object;

    /**
     * Checks if a service exists by its class name.
     *
     * @param string $className The class name of the service to check.
     * @return bool
     */
    public function has(string $className): bool;
}