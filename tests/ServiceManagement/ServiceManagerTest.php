<?php

namespace CommonPHP\Tests\ServiceManagement;

use CommonPHP\ServiceManagement\Exceptions\ServiceNotInstanceOfClassException;
use CommonPHP\Tests\Fixtures\BootstrappedService;
use CommonPHP\Tests\Fixtures\BootstrappedServiceProvider;
use PHPUnit\Framework\TestCase;
use CommonPHP\ServiceManagement\ServiceManager;
use CommonPHP\ServiceManagement\Exceptions\ClassOrInterfaceNotDefinedException;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException;
use CommonPHP\ServiceManagement\Exceptions\ServiceAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\ServiceAlreadySetException;
use CommonPHP\ServiceManagement\Exceptions\ServiceResolutionException;
use CommonPHP\Tests\Fixtures\MockServiceManager;
use CommonPHP\Tests\Fixtures\MockService;
use CommonPHP\Tests\Fixtures\MockSubService;

class ServiceManagerTest extends TestCase
{
    private ServiceManager $serviceManager;

    function setUp(): void
    {
        $this->serviceManager = new ServiceManager();
    }

    function testHasService(): void
    {
        // Check a service that hasn't been registered
        $this->assertFalse($this->serviceManager->has(MockService::class));

        // Check a service that has been registered
        $this->serviceManager->register(MockService::class, ['param1' => 'value1']);
        $this->assertTrue($this->serviceManager->has(MockService::class));
    }

    function testGetService(): void
    {
        // Register a service and retrieve it
        $this->serviceManager->register(MockService::class, ['param1' => 'value1']);
        $service = $this->serviceManager->get(MockService::class);
        $this->assertInstanceOf(MockService::class, $service);
    }

    function testGetServiceFailNotFound(): void
    {

        // Try to get a service that was not registered
        $this->expectException(ServiceNotFoundException::class);
        $this->serviceManager->get('NotRegisteredServiceClass');
    }

    function testRegisterService(): void
    {
        // Test if service is registered properly
        $this->serviceManager->register(MockService::class, ['param1' => 'value1']);
        $this->assertTrue($this->serviceManager->has(MockService::class));
    }

    function testRegisterServiceAlreayRegistered(): void
    {
        $this->serviceManager->register(MockService::class, ['param1' => 'value1']);

        // Test if trying to register the same service throws an exception
        $this->expectException(ServiceAlreadyRegisteredException::class);
        $this->serviceManager->register(MockService::class, ['param1' => 'value1']);
    }

    function testSetService(): void
    {
        // Set a service and retrieve it
        $serviceInstance = new MockService('value1');
        $this->serviceManager->set(MockService::class, $serviceInstance);
        $this->assertSame($serviceInstance, $this->serviceManager->get(MockService::class));
    }

    function testSetServiceFailNotFound(): void
    {
        $serviceInstance = new MockService('value1');
        $this->serviceManager->set(MockService::class, $serviceInstance);

        // Try to set a service instance of a class that wasn't registered before and autoRegister is set to false
        $this->expectException(ServiceNotFoundException::class);
        $this->serviceManager->set('NotRegisteredServiceClass', new MockService('value2'), false);
    }

    function testServiceFailNotInstanceOf(): void
    {
        // Try to set a service instance that is not of the same class or a subclass
        $this->expectException(ServiceNotInstanceOfClassException::class);
        $this->serviceManager->set(MockService::class, new MockSubService('value3'));
    }

    function testSetServiceFailAlreadySet(): void
    {
        $serviceInstance = new MockService('value1');
        $this->serviceManager->set(MockService::class, $serviceInstance);

        // Try to set a service instance that was already set before
        $this->expectException(ServiceAlreadySetException::class);
        $this->serviceManager->set(MockService::class, new MockService('value4'));
    }

    function testServiceBootstrapping()
    {
        $this->serviceManager->register(BootstrappedService::class);;

        $this->assertTrue($this->serviceManager->get(BootstrappedService::class)->wasBootstrapped);
    }
}
