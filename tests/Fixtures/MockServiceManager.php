<?php

namespace CommonPHP\Tests\Fixtures;

use CommonPHP\DependencyInjection\DependencyInjector;
use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;

/**
 * Trimmed down version of the service manager that doesn't provide error handling
 */
class MockServiceManager implements ServiceManagerContract
{
    private array $services = [];
    public readonly DependencyInjector $di;
    private MockServiceProvider $mockServiceProvider;
    public function __construct()
    {
        $this->di = new DependencyInjector();
        $this->di->valueFinder->onLookup([$this, 'lookupValue']);
        $this->mockServiceProvider = new MockServiceProvider($this);
    }

    public function lookupValue(string $name, string $typeName, bool &$found): ?object
    {
        if ($this->has($typeName)) {
            $found = true;
            return $this->get($typeName);
        }
        return null;
    }

    public function register(string $className, array $parameters = []): void
    {
        $this->services[$className] = $parameters;
    }

    public function set(string $className, object $instance, bool $autoRegister = true): void
    {
        $this->services[$className] = $instance;
    }

    public function get(string $className, array $parameters = []): object
    {
        if (!is_object($this->services[$className])) {
            $this->services[$className] = $this->di->instantiate($className, $parameters);
        }
        return $this->services[$className];
    }

    public function has(string $className): bool
    {
        if ($this->mockServiceProvider->supports($className)) return true;
        return array_key_exists($className, $this->services);
    }
}