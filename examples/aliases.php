<?php

// This includes the Composer-generated autoloader,
// which makes the ServiceManager and other classes available for use.
include '../vendor/autoload.php';

// Define a contract for later use.
interface MyContract
{

}

// Define a class that implements the contract.
class MyClass implements MyContract
{

}

// Instantiate the ServiceManager. This will be the main entry point
// for service registration and retrieval.
$services = new CommonPHP\ServiceManagement\ServiceManager();

try {
    // Register MyClass as a service. The ServiceManager will now be aware
    // of MyClass and be able to handle it when requested.
    $services->register(MyClass::class);

    // Register an alias for the MyContract interface. This allows us to ask
    // the ServiceManager for an instance of MyContract and get an instance
    // of MyClass, since MyClass implements MyContract.
    $services->aliases->register(MyContract::class, MyClass::class);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException $e) {
    // The ServiceNotFoundException is thrown if a service that hasn't been registered is attempted to be fetched.
    // In such cases, an appropriate error message should be returned or logged, and the application should be gracefully terminated or the error should be handled appropriately.
    die($e);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceResolutionException $e) {
    // The ServiceResolutionException is thrown when there's an issue with resolving a service's dependencies during its instantiation.
    // When such an exception is encountered, an appropriate error message should be returned or logged, and the application should be gracefully terminated or the error should be handled appropriately.
    die($e);
}

try {
    // Retrieve an instance of MyClass from the ServiceManager. This
    // returns a fully-instantiated object of type MyClass.
    $services->get(MyClass::class);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException $e) {
    // The ServiceNotFoundException is thrown if a service that hasn't been registered is attempted to be fetched.
    // In such cases, an appropriate error message should be returned or logged, and the application should be gracefully terminated or the error should be handled appropriately.
    die($e);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceResolutionException $e) {
    // The ServiceResolutionException is thrown when there's an issue with resolving a service's dependencies during its instantiation.
    // When such an exception is encountered, an appropriate error message should be returned or logged, and the application should be gracefully terminated or the error should be handled appropriately.
    die($e);
}

try {
    // Retrieve an instance of MyContract from the ServiceManager. Since
    // MyContract is an alias for MyClass, this actually returns an instance
    // of MyClass. This demonstrates how aliases can be used to get instances
    // of a specific implementation, even when asking for an interface.
    $services->get(MyContract::class);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceNotFoundException $e) {
    // The ServiceNotFoundException is thrown if a service that hasn't been registered is attempted to be fetched.
    // In such cases, an appropriate error message should be returned or logged, and the application should be gracefully terminated or the error should be handled appropriately.
    die($e);
} catch (CommonPHP\ServiceManagement\Exceptions\ServiceResolutionException $e) {
    // The ServiceResolutionException is thrown when there's an issue with resolving a service's dependencies during its instantiation.
    // When such an exception is encountered, an appropriate error message should be returned or logged, and the application should be gracefully terminated or the error should be handled appropriately.
    die($e);
}
