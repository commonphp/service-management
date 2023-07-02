<?php

namespace CommonPHP\Tests\Fixtures;

use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;

class MockServiceProvider implements ServiceProviderContract
{
    public function __construct()
    {
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