<?php

namespace CommonPHP\Tests\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use CommonPHP\ServiceManagement\Exceptions\NoProviderForServiceException;
use CommonPHP\ServiceManagement\Exceptions\ServiceProviderNotRegisteredException;
use CommonPHP\ServiceManagement\ServiceManager;
use CommonPHP\Tests\Fixtures\BootstrappedService;
use CommonPHP\Tests\Fixtures\BootstrappedServiceProvider;
use CommonPHP\Tests\Fixtures\MockProvidedService;
use CommonPHP\Tests\Fixtures\MockServiceManager;
use CommonPHP\Tests\Fixtures\MockServiceProvider;
use PHPUnit\Framework\TestCase;
use CommonPHP\ServiceManagement\Support\ProviderRegistry;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;

class ProviderRegistryTest extends TestCase
{
    private ProviderRegistry $providerRegistry;
    private ServiceProviderContract $mockProvider;
    private ServiceManager $mockManager;

    function setUp(): void
    {
        $this->mockManager = new ServiceManager();
        $this->providerRegistry = new ProviderRegistry($this->mockManager);
        $this->mockProvider = new MockServiceProvider($this->mockManager);
    }

    function testRegisterAndRetrieveProvider(): void
    {
        // Register provider
        $this->providerRegistry->registerProvider(get_class($this->mockProvider));

        // Check provider
        $this->assertTrue($this->providerRegistry->hasProvider(get_class($this->mockProvider)));
        $this->assertInstanceOf(
            ServiceProviderContract::class,
            $this->providerRegistry->getProvider(get_class($this->mockProvider))
        );
    }

    function testGetProviderFor(): void
    {
        // Register provider
        $this->providerRegistry->registerProvider(get_class($this->mockProvider));

        // Check getProviderFor
        $this->assertInstanceOf(
            MockServiceProvider::class,
            $this->providerRegistry->getProviderFor(MockProvidedService::class)
        );
    }

    function testSupports(): void
    {

        // Register provider
        $this->providerRegistry->registerProvider(get_class($this->mockProvider));

        // Check supports
        $this->assertTrue($this->providerRegistry->supports(MockProvidedService::class));
    }

    function testGet(): void
    {
        // Register provider
        $this->providerRegistry->registerProvider(get_class($this->mockProvider));

        // Check get
        $this->assertInstanceOf(
            MockProvidedService::class,
            $this->providerRegistry->get(MockProvidedService::class)
        );
    }

    function testGetProviderNotFound(): void
    {
        // Check getProvider throws exception if provider not found
        $this->expectException(ServiceProviderNotRegisteredException::class);
        $this->providerRegistry->getProvider('NonExistentProvider');
    }

    function testGetProviderForNotFound(): void
    {
        $this->assertFalse($this->providerRegistry->getProviderFor('NonExistentClass'));
    }

    function testGetNotFound(): void
    {
        // Check get throws exception if provider not found
        $this->expectException(NoProviderForServiceException::class);
        $this->providerRegistry->get('NonExistentClass');
    }

    function testServiceBootstrapping()
    {
        $this->providerRegistry->registerProvider(BootstrappedServiceProvider::class);

        $this->assertTrue($this->providerRegistry->getProvider(BootstrappedServiceProvider::class)->wasBootstrapped);
    }
}
