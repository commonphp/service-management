<?php

namespace CommonPHP\Tests\ServiceManagement;

use CommonPHP\Tests\Fixtures\MockService;
use CommonPHP\Tests\Fixtures\MockSubService;
use PHPUnit\Framework\TestCase;
use CommonPHP\ServiceManagement\ServiceManager;
use CommonPHP\ServiceManagement\ServiceContainer;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException;

class ServiceContainerTest extends TestCase
{
    /**
     * @var ServiceContainer
     */
    private $container;

    protected function setUp(): void
    {
        $manager = new ServiceManager();
        $manager->register(MockService::class);
        $this->container = new ServiceContainer($manager);
    }

    public function testHasMethod()
    {
        // It should return true for a service that is registered
        $this->assertTrue($this->container->has(MockService::class));

        // It should return false for a service that is not registered
        $this->assertFalse($this->container->has(MockSubService::class));
    }

    public function testGetMethod()
    {
        // It should return a service instance for a service that is registered
        $this->assertInstanceOf(MockService::class, $this->container->get(MockService::class));
    }

    public function testGetMethodFailNotFound(): void
    {

        // It should throw ServiceNotFoundException for a service that is not registered
        $this->expectException(ServiceNotFoundException::class);
        $this->container->get(MockSubService::class);
    }
}
