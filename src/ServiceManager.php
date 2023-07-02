<?php

/**
 * ServiceManager
 *
 * The ServiceManager class is responsible for registering, managing and resolving services in your application.
 * It provides an abstraction for handling dependency injection and service provisioning using multiple registries
 * and a dependency injector. These services can be easily accessed and manipulated by class name.
 *
 * Services can be registered explicitly, set with specific instances, and checked for their existence. If a
 * service is requested that hasn't been instantiated yet, the ServiceManager can also handle the instantiation.
 *
 * The ServiceManager hooks into events of the DependencyInjector's valueFinder and ProviderRegistry's instantiation
 * process to provide the services when required.
 *
 * Furthermore, the ServiceManager includes functionality for working with aliases and namespaces, further
 * simplifying the organization of your services.
 *
 * @package    CommonPHP\ServiceManagement
 * @author     Timothy McClatchey <timothy@commonphp.org>
 * @copyright  2023 CommonPHP.org
 * @license    http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement;

use CommonPHP\DependencyInjection\DependencyInjector;
use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use CommonPHP\ServiceManagement\Exceptions\ClassOrInterfaceNotDefinedException;
use CommonPHP\ServiceManagement\Exceptions\ServiceAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\ServiceAlreadySetException;
use CommonPHP\ServiceManagement\Exceptions\ServiceResolutionException;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotInstanceOfClassException;
use CommonPHP\ServiceManagement\Support\AliasRegistry;
use CommonPHP\ServiceManagement\Support\NamespaceRegistry;
use CommonPHP\ServiceManagement\Support\ProviderRegistry;
use Throwable;

final class ServiceManager implements ServiceManagerContract
{
    public readonly AliasRegistry $aliases;
    public readonly NamespaceRegistry $namespaces;
    public readonly ProviderRegistry $providers;
    public readonly DependencyInjector $di;

    // Array to store service configurations and instances
    private array $services = [];

    public function __construct()
    {
        $this->di = new DependencyInjector();
        $this->namespaces = new NamespaceRegistry();
        $this->aliases = new AliasRegistry($this);
        $this->providers = new ProviderRegistry($this);

        // Hooking into the valueFinder's lookup event to find services by their type
        $this->di->valueFinder->onLookup([$this, 'lookupValue']);

        // Register the ServiceContainer itself as a service
        $this->register(ServiceContainer::class, [
            'manager' => $this
        ]);
    }

    /**
     * The lookupValue function is primarily used with the valueFinder's onLookup event.
     * It can be called directly if needed for any future use cases.
     *
     * @param string $name Name of the value being looked up.
     * @param string $typeName The type of the value being looked up.
     * @param bool $found If the value was found, this parameter will be updated to true.
     * @return null|object The found service or null if not found.
     * @throws ServiceNotFoundException
     * @throws ServiceResolutionException
     */
    public function lookupValue(string $name, string $typeName, bool &$found): ?object
    {
        if ($this->has($typeName)) {
            $found = true;
            return $this->get($typeName);
        }
        return null;
    }

    /**
     * Registers a service by its class name with specific parameters.
     *
     * @param string $className The class name of the service to register.
     * @param array $parameters The parameters to pass to the service's constructor.
     * @throws ClassOrInterfaceNotDefinedException
     * @throws ServiceAlreadyRegisteredException
     */
    public function register(string $className, array $parameters = []): void
    {
        // Make sure the class/interface exists
        if (!class_exists($className) && !interface_exists($className)) {
            throw new ClassOrInterfaceNotDefinedException($className);
        }

        // We are bypassing the `has` and `resolve` methods here because set services will always take precedence
        // over aliases, namespaces and service providers
        if (array_key_exists($className, $this->services)) {
            throw new ServiceAlreadyRegisteredException($className);
        }

        $this->services[$className] = $parameters;
    }

    /**
     * Explicitly sets a service by its class name with a specific instance.
     * This method is used when an instance of a service needs to be explicitly set,
     * instead of depending on the DependencyInjector to instantiate it when it's called.
     *
     * @param string $className The class name of the service to set.
     * @param object $instance The instance to set.
     * @param bool $autoRegister If set to true, the service will be auto registered if not already registered.
     * @throws ClassOrInterfaceNotDefinedException
     * @throws ServiceAlreadyRegisteredException
     * @throws ServiceAlreadySetException
     * @throws ServiceNotFoundException
     * @throws ServiceNotInstanceOfClassException
     */
    public function set(string $className, object $instance, bool $autoRegister = true): void
    {
        // The `set` method is used to bypass the dependency injection and explicitly set an instance of a service.
        // We manually check using `array_key_exists` here because we want to bypass the service providers, aliases,
        // and namespaces. We are only interested in the services that have been explicitly registered.
        if (!array_key_exists($className, $this->services)) {
            if (!$autoRegister) {
                throw new ServiceNotFoundException($className);
            }
            $this->register($className, []);
        }

        // Check if it has already been set
        if (is_object($this->services[$className])) {
            throw new ServiceAlreadySetException($className);
        }

        // Ensure the instance is of the expected class or a subclass
        $instanceClass = get_class($instance);
        if ($instanceClass !== $className && !is_subclass_of($className, $instanceClass) && !is_subclass_of($instanceClass, $className))
        {
            throw new ServiceNotInstanceOfClassException($instanceClass, $className);
        }

        // Explicitly set the service to the provided instance
        $this->services[$className] = $instance;
    }

    /**
     * @template T
     * Attempts to retrieve a service by its class name.
     * If the service does not exist, a ServiceNotFoundException will be thrown.
     *
     * @param class-string<T> $className The class name of the service to retrieve.
     * @param array $parameters The parameters to pass to the service's constructor.
     * @return T
     * @throws ServiceNotFoundException
     * @throws ServiceResolutionException
     */
    public function get(string $className, array $parameters = []): object
    {
        $service = $this->resolve($className, true, $parameters);
        if ($service === false) {
            throw new ServiceNotFoundException($className);
        }
        return $service;
    }

    /**
     * Checks if a service exists by its class name.
     *
     * @param string $className The class name of the service to check.
     * @return bool
     */
    public function has(string $className): bool
    {
        return $this->resolve($className, false) !== false;
    }

    /**
     * Resolves a service by its class name.
     * If the service cannot be resolved and does not match a registered namespace, false will be returned.
     *
     * @param string $className The class name of the service to resolve.
     * @param bool $instantiate Whether to instantiate the service if it exists but hasn't been instantiated yet.
     * @param array $parameters The parameters to pass to the service's constructor (used only if instantiation is needed).
     * @return bool|object False if the service cannot be resolved, the instantiated service if it exists, or true if the service exists but $instantiate is false.
     * @throws ServiceResolutionException
     */
    private function resolve(string $className, bool $instantiate, array $parameters = []): bool|object
    {
        // First step is to check if the service has already been registered, and return it,
        // as that will take precedence over the rest.
        if (array_key_exists($className, $this->services)) {
            return $this->resolveLiteral($className, $instantiate);
        }

        // Next is to check if a service provider exists for this specific class
        $serviceProvider = $this->providers->getProviderFor($className);
        if ($serviceProvider !== false) {
            if (!$instantiate) return true;
            return $serviceProvider->handle($className, $parameters);
        }

        // Check if the class is aliased and, if so, get the real class name
        $realClassName = $this->aliases->has($className) ? $this->aliases->get($className) : $className;

        // IF the alias class does not exist, See if the class namespace is in a registered namespace area
        if (!array_key_exists($realClassName, $this->services)) {
            if ($this->namespaces->matches($realClassName)) {
                try {
                    $this->register($realClassName, $parameters);
                } catch (Throwable $t) {
                    throw new ServiceResolutionException($className, previous: $t);
                }
            }
        }

        // Try to resolve the literal service again
        return $this->resolveLiteral($realClassName, $instantiate);
    }

    /**
     * Resolves a literal service (one that has already been registered) by its class name.
     * This function is called by resolve() and attempts to return or instantiate an existing service.
     *
     * @param string $className The class name of the service to resolve.
     * @param bool $instantiate Whether to instantiate the service if it exists but hasn't been instantiated yet.
     * @return bool|object False if the service cannot be resolved, the instantiated service if it exists, or true if the service exists but $instantiate is false.
     * @throws ServiceResolutionException
     */
    private function resolveLiteral(string $className, bool $instantiate): bool|object
    {
        // If the service exists, return true or instantiate (if needed) and return
        // the object depending on the $instantiate state
        if (array_key_exists($className, $this->services)) {
            if (!$instantiate) return true;
            if (!is_object($this->services[$className])) {
                try {
                    $this->services[$className] = $this->di->instantiate($className, $this->services[$className]);
                    if ($this->services[$className] instanceof BootstrapperContract)
                    {
                        $this->services[$className]->bootstrap($this);
                    }
                } catch (Throwable $t) {
                    throw new ServiceResolutionException($className, previous: $t);
                }
            }
            return $this->services[$className];
        }

        // There was no service found
        return false;
    }
}