<?php

namespace CommonPHP\Tests\Fixtures;

use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;

class MockServiceProvider implements ServiceProviderContract
{
    private ServiceManagerContract $serviceManager;

    public function __construct(ServiceManagerContract $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    public function supports(string $className): bool
    {
        return $className === MockProvidedService::class;
    }

    public function handle(string $className, array $parameters = []): object
    {
        if ($className !== MockProvidedService::class) throw new \Exception();
        return new MockProvidedService();
    }

    public function isSingletonExpected(string $className): bool
    {
        return true;
    }
}