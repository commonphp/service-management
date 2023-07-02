<?php

/**
 * BootstrapperContract Interface
 *
 * This interface is implemented by services that need to perform some action upon instantiation
 * that cannot be handled by the constructor alone. For instance, injecting dependencies that
 * were not known at compile time.
 *
 * Services implementing this interface will have their `bootstrap` method called automatically
 * by the Service Manager after instantiation.
 *
 * WARNING: The `bootstrap` method is intended to be invoked internally by the Service Manager
 * only. It is not a part of the public API of the service, and invoking it manually may lead
 * to unexpected behavior.
 *
 * @package    CommonPHP\ServiceManagement
 * @subpackage Contracts
 * @author     Timothy McClatchey <timothy@commonphp.org>
 * @copyright  2023 CommonPHP.org
 * @license    http://opensource.org/licenses/MIT MIT License
 */

namespace CommonPHP\ServiceManagement\Contracts;

use CommonPHP\ServiceManagement\ServiceManager;

interface BootstrapperContract
{
    /**
     * Perform any necessary bootstrap actions for this service. This shouldn't be used with every service, just those
     * that need direct access to the ServiceManager or DependencyInjector in order to enable functionality based on
     * its own requirements.
     *
     * This method should only be called by the ServiceManager and is only called against direct services and Service
     * Providers, but should not be called against services created by the service provider or anywhere else outside of
     * the ServiceManagement library
     *
     * @internal
     *
     * @param ServiceManager $serviceManager
     */
    function bootstrap(ServiceManager $serviceManager): void;
}