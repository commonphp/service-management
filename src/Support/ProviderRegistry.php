<?php

/**
 * This class is responsible for managing service providers which are classes
 * that implement the ServiceProviderContract. Each service provider is responsible
 * for handling its own service classes.
 *
 * @package    CommonPHP\ServiceManagement
 * @subpackage Support
 * @author     Timothy McClatchey <timothy@commonphp.org>
 * @copyright  2023 CommonPHP.org
 * @license    http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;
use CommonPHP\ServiceManagement\Exceptions\NoProviderForServiceException;
use CommonPHP\ServiceManagement\Exceptions\ServiceProviderAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\ServiceProviderMissingContractException;
use CommonPHP\ServiceManagement\Exceptions\ServiceProviderNotFoundException;
use CommonPHP\ServiceManagement\Exceptions\ServiceProviderNotRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\ServiceProviderRegistrationException;
use CommonPHP\ServiceManagement\ServiceManager;
use Throwable;

final class ProviderRegistry
{
    private ServiceManager $manager;

    /** @var ServiceProviderContract[] */
    private array $providers = [];

    public function __construct(ServiceManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Register a service provider that handles its own service classes
     *
     * @param string $providerClassName The class name of the service provider, it must implement ServiceProviderContract
     * @param array $parameters Parameters to pass to the constructor
     * @return void
     * @throws ServiceProviderAlreadyRegisteredException
     * @throws ServiceProviderMissingContractException
     * @throws ServiceProviderNotFoundException
     * @throws ServiceProviderRegistrationException
     */
    public function registerProvider(string $providerClassName, array $parameters = []): void
    {
        if (!class_exists($providerClassName)) {
            throw new ServiceProviderNotFoundException($providerClassName);
        }

        if ($this->hasProvider($providerClassName)) {
            throw new ServiceProviderAlreadyRegisteredException($providerClassName);
        }

        if (!is_subclass_of($providerClassName, ServiceProviderContract::class)) {
            throw new ServiceProviderMissingContractException($providerClassName);
        }

        try {
            $this->providers[$providerClassName] = $this->manager->di->instantiate($providerClassName, $parameters);
            if ($this->providers[$providerClassName] instanceof BootstrapperContract)
            {
                $this->providers[$providerClassName]->bootstrap($this->manager);
            }
        } catch (Throwable $t) {
            throw new ServiceProviderRegistrationException($providerClassName, previous: $t);
        }
    }

    /**
     * Check if a provider is registered.
     *
     * @param string $providerClassName The fully qualified class name of the provider.
     * @return bool
     */
    public function hasProvider(string $providerClassName): bool
    {
        return array_key_exists($providerClassName, $this->providers);
    }

    /**
     * Get a registered provider.
     *
     * @param string $providerClassName The fully qualified class name of the provider.
     * @throws ServiceProviderNotRegisteredException
     * @return ServiceProviderContract
     */
    public function getProvider(string $providerClassName): ServiceProviderContract
    {
        if (!$this->hasProvider($providerClassName)) {
            throw new ServicePRoviderNotRegisteredException($providerClassName);
        }
        return $this->providers[$providerClassName];
    }

    /**
     * Get the provider for a particular class.
     *
     * @param string $className
     * @return false|ServiceProviderContract
     */
    public function getProviderFor(string $className): false|ServiceProviderContract
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($className)) return $provider;
        }
        return false;
    }

    /**
     * Check if a provider supports a class.
     *
     * @param string $className The fully qualified class name of the service.
     * @return bool
     */
    public function supports(string $className): bool
    {
        foreach ($this->providers as $provider) {
            if ($provider->supports($className)) return true;
        }
        return false;
    }

    /**
     * Get a service instance.
     *
     * @param string $className The fully qualified class name of the service.
     * @param array $parameters Parameters to pass to the service's constructor.
     * @throws NoProviderForServiceException
     * @return object
     */
    public function get(string $className, array $parameters = []): object
    {
        $provider = $this->getProviderFor($className);
        if ($provider === false) {
            throw new NoProviderForServiceException($className);
        }
        return $provider->handle($className, $parameters);
    }
}