<?php

/**
 * Specifies the bootstrap process for services requiring initialization beyond constructor injection.
 *
 * This interface is for services that require additional setup after instantiation, which cannot be
 * accomplished through constructor dependency injection alone. Implementing services will have their
 * `bootstrap` method called by the ServiceManager, providing them access to the ServiceManager or
 * DependencyInjector for further configuration or dependency resolution.
 *
 * @package CommonPHP\ServiceManagement
 * @subpackage Contracts
 * @author Timothy McClatchey <timothy@commonphp.org>
 * @copyright 2024 CommonPHP.org
 * @license http://opensource.org/licenses/MIT MIT License
 * @internal This interface's methods are intended for internal use by the ServiceManager only.
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