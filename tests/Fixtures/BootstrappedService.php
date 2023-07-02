<?php

namespace CommonPHP\Tests\Fixtures;

use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\ServiceManager;

class BootstrappedService implements BootstrapperContract
{
    public $wasBootstrapped = false;
    function bootstrap(ServiceManager $serviceManager): void
    {
        $this->wasBootstrapped = true;
    }
}