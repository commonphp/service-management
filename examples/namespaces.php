<?php

// Start in the global namespace to include the Composer-generated autoloader,
// which makes the ServiceManager and other classes available for use.
namespace {
    include '../vendor/autoload.php';

    // Define a class in the root namespace.
    class MyRootClass
    {

    }
}

// Move into a specific namespace to define a namespaced class.
namespace CommonPHPExamples\ServiceManagement\NamespaceExample
{
    class MyNamespacedClass
    {

    }
}

// Move back into the global namespace to continue with the example.
namespace {
    // Import the namespaced class into the global namespace so it can be referred to
    // without the full namespace prefix.
    use CommonPHPExamples\ServiceManagement\NamespaceExample\MyNamespacedClass;

    // Instantiate the ServiceManager. This will be the main entry point
    // for service registration and retrieval.
    $services = new CommonPHP\ServiceManagement\ServiceManager();

    // Register a namespace with the ServiceManager. Any classes requested from this
    // namespace will be handled automatically by the ServiceManager without requiring
    // explicit registration.
    $services->namespaces->register('CommonPHPExamples\\ServiceManagement\\NamespaceExample');

    // Ask the ServiceManager for an instance of the namespaced class. Since the
    // namespace was registered with the ServiceManager, this will succeed.
    $services->get(MyNamespacedClass::class); // Succeeds

    try {
        // Ask the ServiceManager for an instance of the root class. Since the root
        // namespace was not registered with the ServiceManager, this will fail.
        $services->get(MyRootClass::class); // Fails
    } catch (Throwable $t) {
        // Failed as expected
    }
}
