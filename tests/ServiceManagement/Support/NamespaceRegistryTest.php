<?php

namespace CommonPHP\Tests\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Exceptions\NamespaceAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\NamespaceInvalidException;
use PHPUnit\Framework\TestCase;
use CommonPHP\ServiceManagement\Support\NamespaceRegistry;

class NamespaceRegistryTest extends TestCase
{
    private NamespaceRegistry $namespaceRegistry;

    function setUp(): void
    {
        $this->namespaceRegistry = new NamespaceRegistry();
    }

    function testMatches(): void
    {
        // Register namespace
        $this->namespaceRegistry->register('TestNamespace');

        // Check matches
        $this->assertTrue($this->namespaceRegistry->matches('TestNamespace\MyClass'));
        $this->assertFalse($this->namespaceRegistry->matches('AnotherNamespace\MyClass'));
    }

    function testRegisterInvalidNamespace(): void
    {
        // Attempt to register invalid namespace - expect an exception
        $this->expectException(NamespaceInvalidException::class);
        $this->namespaceRegistry->register('');
    }

    function testRegisterExistingNamespace(): void
    {
        // Register namespace
        $this->namespaceRegistry->register('TestNamespace');

        // Attempt to register the same namespace again - expect an exception
        $this->expectException(NamespaceAlreadyRegisteredException::class);
        $this->namespaceRegistry->register('TestNamespace');
    }
}
