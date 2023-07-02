<?php

// Include the Composer-generated autoloader to make ServiceManager and other classes available for use.
use CommonPHP\ServiceManagement\Contracts\ServiceManagerContract;

include '../vendor/autoload.php';

// Define a custom service that your application requires.
class MyCustomService
{
    // This service depends on a message string.
    private string $message;
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    // A method to echo the message passed in the constructor.
    public function echoMessage(): void
    {
        echo $this->message;
    }
}

// Define a custom service provider that can provide instances of MyCustomService.
class MyCustomServiceProvider implements CommonPHP\ServiceManagement\Contracts\ServiceProviderContract
{
    private ?MyCustomService $service = null;

    // The service provider depends on the ServiceManager.
    private CommonPHP\ServiceManagement\Contracts\ServiceManagerContract $serviceManager;
    public function __construct(CommonPHP\ServiceManagement\Contracts\ServiceManagerContract $serviceManager)
    {
        // The $serviceManager parameter name is explicit, it must be exactly this type and exactly this name.
        $this->serviceManager = $serviceManager;
    }

    // The supports method checks if this service provider can provide instances of a given class.
    public function supports(string $className): bool
    {
        return $className == MyCustomService::class;
    }

    // The handle method is responsible for actually providing instances of the service.
    public function handle(string $className, array $parameters = []): object
    {
        // Ensure this provider supports the requested class.
        if ($className == MyCustomService::class) {
            if (!isset($this->service)) {
                // Create a new instance of the service, using the DependencyInjector to handle any dependencies.
                $this->service = $this->serviceManager->di->instantiate(
                    MyCustomService::class,
                    $parameters
                );
            }
            // Return the service instance.
            return $this->service;
        }
        // If this provider doesn't support the requested class, throw an exception.
        throw new Exception(); // This should not occur, as the service manager should have checked supports() first.
    }

    // The isSingletonExpected method checks if this provider is expected to always provide the same instance of the service.
    public function isSingletonExpected(string $className): bool
    {
        // In this case, MyCustomService is a singleton service - only one instance is allowed.
        return true;
    }
}

// Instantiate the ServiceManager and register the custom service provider.
$services = new CommonPHP\ServiceManagement\ServiceManager();
$services->providers->registerProvider(MyCustomServiceProvider::class);

// Request an instance of MyCustomService, passing 'message' as a parameter.
$obj = $services->get(MyCustomService::class, ['message' => 'Hello, World!']);
// Use the service to print out the message.
$obj->echoMessage();

// This will print out "Hello, World!"
