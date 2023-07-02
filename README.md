# CommonPHP - Service Manager

CommonPHP's Service Manager is a comprehensive solution for managing and injecting services throughout your PHP application. It provides an elegant and powerful API that allows you to manage service life-cycles, register and retrieve services, and work with service providers, amongst other capabilities.

## Features

- Automatic dependency injection
- Singleton and transient service lifetimes
- Aliasing and interface binding
- Namespace-based service registration
- Custom service providers

## ServiceManager vs ServiceContainer

To keep the management and utilization of services logically separated and maintain a clean architecture, we've divided these responsibilities into two main classes: `ServiceManager` and `ServiceContainer`.

The `ServiceManager` is responsible for the registration, instantiation, and general management of services. It serves as the hub where services are defined, dependencies are resolved, and lifetimes are managed. It is meant to be utilized during the bootstrapping or startup phase of your application.

Conversely, the `ServiceContainer` is designed to be a consumer of these services during the application's execution. It provides a simplified, read-only interface for accessing services managed by the `ServiceManager`. This approach allows for an explicit and clear distinction between service configuration and consumption, fostering cleaner, more maintainable code.

## Requirements

The CommonPHP framework requires PHP 8.1 or newer. This library specifically has the following dependencies:

- `comphp/di` package: This library is built upon the `comphp/di` dependency injection package, and it is a necessary requirement for the functioning of this Service Management library.


## Installation

You can install `CommonPHP\ServiceManagement` using [Composer](https://getcomposer.org/):

```shell
composer require comphp/service-management
```

### Basic Usage

The primary class of the Service Manager is `CommonPHP\ServiceManager\ServiceManager`. Start by creating a new instance of `ServiceManager`:

```php
$services = new CommonPHP\ServiceManager\ServiceManager();
```

The `ServiceManager` instance provides several methods for managing and retrieving services.

**Registering Services**

You can register services using the `register` method:

```php
$services->register(MyClass::class);
```

This registers the service by its class name. You can then retrieve instances of the service using the `get` method (see below).

**Retrieving Services**

Use the `get` method to retrieve services:

```php
$instance = $services->get(MyClass::class);
```

This retrieves a new instance of the registered service.

**Registering Aliases**

The `aliases` property of the `ServiceManager` is an instance of `AliasRegistry` which lets you register service aliases:

```php
$services->aliases->register(MyInterface::class, MyClass::class);
```

In this example, the `MyInterface` is aliased to the `MyClass`. Therefore, when a service requests `MyInterface`, an instance of `MyClass` is returned.

**Registering Namespaces**

The `namespaces` property of the `ServiceManager` is an instance of `NamespaceRegistry` which lets you register entire namespaces:

```php
$services->namespaces->register('MyNamespace');
```

All classes in the registered namespace are treated as services.

**Registering Service Providers**

The `providers` property of the `ServiceManager` is an instance of `ProviderRegistry` which lets you register service providers:

```php
$services->providers->registerProvider(MyServiceProvider::class);
```

Service providers are classes that implement the `ServiceProviderContract` and are responsible for providing instances of services.

## Documentation

Please see the examples directory for more detailed examples on how to use each of the features provided by the Service Manager.

### API Reference

### API Reference

This is a high-level overview of the API. For detailed information about classes, methods, and properties, please refer to the source code and accompanying PHPDoc comments.

- **`CommonPHP\ServiceManagement\ServiceManager`**: The main service management class, providing access to all service management features.

  - **`AliasRegistry $aliases`**: Registry for service aliases. Allows services to be retrieved by alternate names.

  - **`NamespaceRegistry $namespaces`**: Registry for service namespaces. Allows services to be retrieved by namespace.

  - **`ProviderRegistry $providers`**: Registry for service providers. Allows services to be retrieved by provider.

  - **`ServiceContainer $di`**: Dependency injection container for services.

  - **`register(string $class, array $params = []): void`**: Registers a service by class name with optional parameters.

  - **`set(string $name, object $instance): void`**: Stores a named instance in the service container.

  - **`get(string $name, array $params = []): object`**: Retrieves an instance of a service.

  - **`has(string $name): bool`**: Checks if a service is registered or not.

- **`CommonPHP\ServiceManagement\ServiceContainer`**: Class for dependency injection container, allowing services to retrieve other services.

  - **`get(string $name, array $params = []): object`**: Retrieves an instance of a service.

  - **`has(string $name): bool`**: Checks if a service is available in the container.

- **`CommonPHP\ServiceManagement\Contracts\ServiceProviderContract`**: Interface for creating custom service providers.

  - **`supports(string $className): bool`**: Checks if this provider can support the given class.

  - **`handle(string $className, array $parameters = []): object`**: Handles the creation of an instance of the supported class.

  - **`isSingletonExpected(string $className): bool`**: Checks if the service is expected to be a singleton or not.

- **`CommonPHP\ServiceManagement\Support\AliasRegistry`**: Class for managing service aliases.

  - **`has(string $alias): bool`**: Checks if an alias is registered.

  - **`get(string $alias): string`**: Retrieves the class name associated with the alias.

  - **`register(string $alias, string $class): void`**: Registers a new alias.

- **`CommonPHP\ServiceManagement\Support\NamespaceRegistry`**: Class for managing service namespaces.

  - **`matches(string $className): bool`**: Checks if a class name matches the registered namespace.

  - **`register(string $namespace): void`**: Registers a new namespace.

- **`CommonPHP\ServiceManagement\Support\ProviderRegistry`**: Class for managing service providers.

  - **`registerProvider(string $providerClass): void`**: Registers a new service provider.

  - **`hasProvider(string $providerClass): bool`**: Checks if a service provider is registered.

  - **`getProvider(string $providerClass): ServiceProviderContract`**: Retrieves an instance of a registered service provider.

  - **`getProviderFor(string $className): ServiceProviderContract`**: Retrieves a service provider that supports the given class.

  - **`supports(string $className): bool`**: Checks if a provider supports a specific class.

  - **`get(string $className, array $parameters = []): object`**: Retrieves an instance of a service from a provider.


### Examples

Here are some examples of using CommonPHP\ServiceManager. You can find the full source code for these examples in the `examples` directory of this repository.

- [**Alias Registry**](https://github.com/commonphp/di/blob/master/examples/aliases.php): Demonstrates how to use the alias registry to create an alias of a service (see `examples/aliases.php`).

- [**Namespace Registry**](https://github.com/commonphp/di/blob/master/examples/namespaces.php): Demonstrates how to use the namespace registry to register a namespace, so all classes within that namespace are treated as services (see `examples/namespaces.php`).

- [**Service Container**](https://github.com/commonphp/di/blob/master/examples/service-container.php): Demonstrates how to pass a service container to services, providing them with a way to request other services (see `examples/service-container.php`).

- [**Service Providers**](https://github.com/commonphp/di/blob/master/examples/service-providers.php): Demonstrates how to create and register a custom service provider for providing instances of a service (see `examples/service-providers.php`).

## Contributing

Contributions are always welcome! Please read the [contribution guidelines](CONTRIBUTING.md) first.

## Testing

This project uses PHPUnit for unit testing. Follow the instructions below to run the tests:

1. Ensure you have PHPUnit installed. If not, you can install it with Composer:

    ```bash
    composer require --dev phpunit/phpunit
    ```

2. Navigate to the project's root directory.

3. Run the tests using the following command:

    ```bash
    ./vendor/bin/phpunit tests
    ```

4. If the tests are successful, you will see output similar to:

    ```
    PHPUnit 9.6.9 by Sebastian Bergmann and contributors.
    
    
    
    Time: 00:00.374, Memory: 6.00 MB
    
    OK (29 tests, 36 assertions)
    
    Process finished with exit code 0
    ```

We recommend regularly running these tests during development to help catch any potential issues early. We also strive for a high level of test coverage, and additions to the codebase should ideally include corresponding tests.

For more detailed output or for integration into continuous integration (CI) systems, PHPUnit can generate a log file in a variety of formats. Check the [PHPUnit documentation](https://phpunit.de/documentation.html) for more information.

## License

This project is licensed under the MIT License. See the [LICENSE.md](LICENSE.md) file for details.
