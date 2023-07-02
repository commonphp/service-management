<?php

namespace CommonPHP\Tests\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;
use CommonPHP\ServiceManagement\Exceptions\AliasAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\AliasClassNotDerivedException;
use CommonPHP\ServiceManagement\Exceptions\AliasClassNotFoundException;
use CommonPHP\ServiceManagement\Exceptions\AliasNotRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException;
use CommonPHP\ServiceManagement\Support\AliasRegistry;
use CommonPHP\Tests\Fixtures\AliasServiceClass;
use CommonPHP\Tests\Fixtures\AliasSubContract;
use CommonPHP\Tests\Fixtures\AliasTestClass;
use CommonPHP\Tests\Fixtures\AnotherAliasServiceButNotDerivedClass;
use CommonPHP\Tests\Fixtures\AnotherAliasServiceClass;
use CommonPHP\Tests\Fixtures\MockServiceManager;
use PHPUnit\Framework\TestCase;

class AliasRegistryTest extends TestCase
{
    private ServiceManagerContract $serviceManagerContract;
    private AliasRegistry $aliasRegistry;

    function setUp(): void
    {
        $this->serviceManagerContract = new MockServiceManager();
        $this->aliasRegistry = new AliasRegistry($this->serviceManagerContract);
        $this->serviceManagerContract->register(AliasServiceClass::class);
    }

    function testRegisterAndHasAlias(): void
    {
        // Alias does not exist initially
        $this->assertFalse($this->aliasRegistry->has(AliasTestClass::class));
        $this->assertFalse($this->aliasRegistry->has(AliasSubContract::class));

        // Register alias
        $this->aliasRegistry->register(AliasTestClass::class, AliasServiceClass::class);
        $this->aliasRegistry->register(AliasSubContract::class, AliasServiceClass::class);

        // Alias exists after registering
        $this->assertTrue($this->aliasRegistry->has(AliasTestClass::class));
        $this->assertTrue($this->aliasRegistry->has(AliasSubContract::class));
    }

    function testRegisterExistingAlias(): void
    {
        // Register alias
        $this->aliasRegistry->register(AliasTestClass::class, AliasServiceClass::class);

        // Attempt to register the same alias again - expect an exception
        $this->expectException(AliasAlreadyRegisteredException::class);
        $this->aliasRegistry->register(AliasTestClass::class, AnotherAliasServiceClass::class);
    }

    function testRegisterMissingService(): void
    {
        // Attempt to register the same alias again - expect an exception
        $this->expectException(ServiceNotFoundException::class);
        $this->aliasRegistry->register(AliasTestClass::class, 'NonexistentClass');
    }

    function testRegisterMissingClass(): void
    {
        // Attempt to register the same alias again - expect an exception
        $this->expectException(AliasClassNotFoundException::class);
        $this->aliasRegistry->register('NonexistentClass', AliasServiceClass::class);
    }

    function testRegisterNotDerived(): void
    {
        // Attempt to register the same alias again - expect an exception
        $this->expectException(AliasClassNotDerivedException::class);
        $this->aliasRegistry->register(AnotherAliasServiceButNotDerivedClass::class, AliasServiceClass::class);
    }

    function testGetAlias(): void
    {
        // Register alias
        $this->aliasRegistry->register(AliasTestClass::class, AliasServiceClass::class);

        // Resolve alias
        $this->assertEquals(AliasServiceClass::class, $this->aliasRegistry->get(AliasTestClass::class));
    }

    function testGetNonexistentAlias(): void
    {
        // Attempt to resolve a nonexistent alias - expect an exception
        $this->expectException(AliasNotRegisteredException::class);
        $this->aliasRegistry->get('NonexistentClass');
    }
}