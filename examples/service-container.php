<?php

// Include the Composer-generated autoloader to make ServiceManager and other classes available for use.
include '../vendor/autoload.php';

// Define a class which represents a service in your application.
class MyServiceClass
{
    // This service depends on a message string and a ServiceContainer.
    private string $message;
    public function __construct(string $message, CommonPHP\ServiceManagement\ServiceContainer $container)
    {
        // Note that the ServiceContainer is automatically injected.
        $this->message = $message;
    }

    // A method to echo the message passed in the constructor.
    public function echoMessage(): void
    {
        echo $this->message;
    }
}

// Define a class that depends on the MyServiceClass.
class MyClass
{
    private MyServiceClass $myService;
    public function __construct(MyServiceClass $myService)
    {
        // The MyServiceClass instance is automatically injected by the DependencyInjector.
        $this->myService = $myService;
    }

    public function run()
    {
        // This method runs the service, causing it to print the message passed in the constructor.
        $this->myService->echoMessage(); // print: Hello, World!
    }
}

// Instantiate the ServiceManager, which will also create the ServiceContainer.
$services = new CommonPHP\ServiceManagement\ServiceManager();

try {
    // Register MyServiceClass with the ServiceManager, including its required 'message' parameter.
    $services->register(MyServiceClass::class, [
        'message' => 'Hello, World!'
    ]);
} catch (CommonPHP\ServiceManagement\Exceptions\ClassOrInterfaceNotDefinedException $e) {
    // This exception is thrown when a non-existent class or interface is being registered or fetched.
    // Proper error message should be returned or logged, and the error should be handled appropriately.
    die($e);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceAlreadyRegisteredException $e) {
    // This exception is thrown when a service is being registered more than once.
    // Proper error message should be returned or logged, and the error should be handled appropriately.
    die($e);
}

// Instantiate MyClass, which will also instantiate its MyServiceClass dependency via the DependencyInjector.
$obj = $services->di->instantiate(MyClass::class, []); // NOTE: there are multiple DI exceptions that can be thrown from here

// Run MyClass, which will in turn run the echoMessage method on MyServiceClass, printing 'Hello, World!'
$obj->run();
