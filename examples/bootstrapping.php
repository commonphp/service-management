<?php

require __DIR__ . '/../vendor/autoload.php';

use CommonPHP\ServiceManagement\ServiceManager;
use CommonPHP\ServiceManagement\Contracts\BootstrapperContract;
use CommonPHP\ServiceManagement\Contracts\ServiceProviderContract;

class MyService implements BootstrapperContract
{
    public function bootstrap(ServiceManager $serviceManager): void
    {
        // Bootstrap logic goes here
        echo "MyService's bootstrap method was called\n";
    }
}

class MyServiceProvider implements ServiceProviderContract, BootstrapperContract
{
    public function bootstrap(ServiceManager $serviceManager): void
    {
        // Bootstrap logic goes here
        echo "MyServiceProvider's bootstrap method was called\n";
    }

    public function supports(string $className): bool
    {
        // Implementation goes here
        return true;
    }

    public function handle(string $className, array $parameters = []): object
    {
        // Implementation goes here
        return new MyService();
    }

    public function isSingletonExpected(string $className): bool
    {
        // Implementation goes here
        return true;
    }
}

// Instantiate the service manager
$serviceManager = new ServiceManager();

// Register MyService
$serviceManager->register(MyService::class);

// Register MyServiceProvider
$serviceManager->providers->registerProvider(MyServiceProvider::class);

// Get MyService
// The bootstrap method will be called automatically by the service manager
$myService = $serviceManager->get(MyService::class);

// Get a service through MyServiceProvider
// The bootstrap method of MyServiceProvider will be called automatically by the service manager
$myServiceViaProvider = $serviceManager->providers->get(MyService::class);