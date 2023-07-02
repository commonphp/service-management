<?php

namespace CommonPHP\Tests\Fixtures;

use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;
use CommonPHP\ServiceManagement\ServiceManager;

class BootstrappedServiceProvider implements BootstrapperContract, ServiceProviderContract
{
    public $wasBootstrapped = false;
    function bootstrap(ServiceManager $serviceManager): void
    {
        $this->wasBootstrapped = true;
    }

    public function supports(string $className): bool
    {
        return false;
    }

    public function handle(string $className, array $parameters = []): object
    {
        // This technically wouldn't be called in the fixture test because supports(...) returns false.
        return new $className();
    }

    public function isSingletonExpected(string $className): bool
    {
        return true;
    }
}