<?php

/**
 * The ServiceProviderContract interfaces defines the contract that service providers must implement. When a service
 * provider is registered, it is
 *
 * @package    CommonPHP\ServiceManagement
 * @subpackage Contracts
 * @author     Timothy McClatchey <timothy@commonphp.org>
 * @copyright  2023 CommonPHP.org
 * @license    http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Contracts;

/**
 * The ServiceProviderContract interface defines the contract that service providers should implement.
 */
interface ServiceProviderContract
{
    /**
     * Check if the service provider supports the given class name.
     *
     * @param class-string $className The class name to check
     * @return bool
     */
    public function supports(string $className): bool;

    /**
     * @template T
     * Instantiate a service of the given class name with optional parameters.
     *
     * @param class-string<T> $className  The class name of the service to instantiate.
     * @param array  $parameters Optional parameters to pass to the constructor.
     * @return T
     */
    public function handle(string $className, array $parameters = []): object;

    /**
     * Check if the service provider is expecting to return a singleton for the given class
     *
     * @param class-string $className The class name to check
     * @return bool
     */
    public function isSingletonExpected(string $className): bool;
}