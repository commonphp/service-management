<?php

/**
 * Manages registration and resolution of namespaces within the service management framework.
 *
 * This class acts as a central registry for namespaces, providing functionalities to register new namespaces and
 * to check if a given class name belongs to any of the registered namespaces. It plays a critical role in
 * organizing service classes and ensuring that namespace-based service resolution operates efficiently and
 * without conflicts. Exceptions are thrown to handle attempts to register invalid or duplicate namespaces,
 * maintaining the integrity of the registry.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Support
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Exceptions\NamespaceAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\NamespaceInvalidException;

final class NamespaceRegistry
{
    /** @var string[] Registered namespaces. */
    private array $namespaces = [];

    /**
     * Determines if a class name matches any of the registered namespaces.
     *
     * This method iterates over all registered namespaces, checking if the class name provided as an argument
     * starts with any of the registered namespace prefixes. This is used to verify if a class belongs to a
     * namespace that is recognized by the service management system.
     *
     * @param string $className The fully qualified class name to check.
     * @return bool True if the class name matches a registered namespace, false otherwise.
     */
    public function matches(string $className): bool
    {
        foreach ($this->namespaces as $namespace) {
            if (str_starts_with($className, $namespace)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Registers a new namespace for service class organization.
     *
     * Validates the provided namespace and ensures it ends with a backslash, appending one if necessary.
     * It throws specific exceptions for invalid namespaces or attempts to register a namespace that has
     * already been registered, ensuring the integrity and uniqueness of namespace registrations.
     *
     * @param string $namespace The namespace to register, validated for proper syntax.
     * @throws NamespaceInvalidException If the namespace is syntactically invalid.
     * @throws NamespaceAlreadyRegisteredException If the namespace is already registered.
     */
    public function register(string $namespace): void
    {
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_\\\\]*$/m', $namespace)) {
            throw new NamespaceInvalidException($namespace);
        }

        if (!str_ends_with($namespace, "\\")) {
            $namespace .= "\\";
        }

        // If the namespace is already registered, throw an exception
        if (in_array($namespace, $this->namespaces)) {
            throw new NamespaceAlreadyRegisteredException($namespace);
        }

        // Register the namespace.
        $this->namespaces[] = $namespace;
    }
}