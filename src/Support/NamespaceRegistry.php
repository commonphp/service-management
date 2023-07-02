<?php

/**
 * Class NamespaceRegistry
 *
 * This class serves as a registry for namespaces. It offers methods for
 * checking if a class belongs to any of the registered namespaces and
 * for registering new namespaces. It throws exceptions in case of
 * invalid or already registered namespaces.
 *
 * @package    CommonPHP\ServiceManagement
 * @subpackage Support
 * @author     Timothy McClatchey <timothy@commonphp.org>
 * @copyright  2023 CommonPHP.org
 * @license    http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Support;

use CommonPHP\ServiceManagement\Exceptions\NamespaceAlreadyRegisteredException;
use CommonPHP\ServiceManagement\Exceptions\NamespaceInvalidException;

final class NamespaceRegistry
{
    /** @var string[] */
    private array $namespaces = [];


    /**
     * Check if a class belongs to any of the registered namespaces.
     *
     * @param string $className The fully qualified name of the class to check.
     * @return bool
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
     * Register a new namespace.
     *
     * The method validates the namespace and appends a trailing backslash if necessary.
     * It throws an exception if the namespace is invalid or already registered.
     *
     * @param string $namespace The namespace to register.
     * @throws NamespaceInvalidException
     * @throws NamespaceAlreadyRegisteredException
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