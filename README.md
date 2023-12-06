# PHP Router

[![Latest Version](https://img.shields.io/badge/version-0.0.0--alpha-blue.svg)](https://github.com/oladesoftware/router)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

A simple lightweight router implementation for handling HTTP routes written in PHP. It allows you to define routes with associated targets, such as controller classes, closures, or functions. The class supports middleware assignment for more advanced routing scenarios.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)
- [License](#license)
- [Contributing](#contributing)
- [Developer](#developer)
- [Author](#author)

## Features

- **Route Configuration**: Easily configure routes with HTTP methods, paths, and targets.
- **Middleware Support**: Assign middleware to routes for additional processing.
- **Dynamic Path Parameters**: Define paths with placeholders to capture dynamic values.
- **Route Matching**: Match requested paths and methods against configured routes.
- **Execution of Actions**: Execute actions based on matched route details.

## Installation

To use the Router Class, download the latest release from the [Releases section](https://github.com/oladesoftware/router/releases) of the GitHub repository. After downloading the appropriate file, include it in your project and instantiate the `Router` class as follows:

```php
require_once 'path/to/Router.php';

use Oladesoftware\Router\Router;

// Create a new router instance
$router = new Router();

// Start adding routes and defining your application's behavior.
```

You can install Oladesoftware Router using Composer. Run the following command in your project's root directory:

```php
composer require oladesoftware/router
```

## Usage

### Basic Usage

```php
use Oladesoftware\Router\Router;

// Create a new router instance
$router = new Router();

// Add a route
$router->addRoute('GET', '/example', ['controller' => 'ExampleController', 'method' => 'index']);

// Match a requested path and method
$result = $router->match('/example', 'GET');

// Execute the matched action
$response = $router->run($result);
```

### Middleware Usage

```php
use Oladesoftware\Router\Router;

// Create a new router instance
$router = new Router();

// Add a route with middleware
$router->addRoute('GET', '/authenticated', ['controller' => 'AuthController', 'method' => 'index'])
    ->middleware('auth');

// Match a requested path and method
$result = $router->match('/authenticated', 'GET');

// Execute the matched action with middleware
$response = $router->run($result);
```

## Examples

### Adding a Named Route

```php
$router->addRoute('GET', '/home', ['controller' => 'HomeController', 'method' => 'index'], 'home');
```

### Middleware Assignment

```php
$router->addRoute('GET', '/admin', ['controller' => 'AdminController', 'method' => 'dashboard'])
    ->middleware('admin_auth');
```

## License

The Router class is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Contributing

Contributions are welcome! Feel free to submit issues or pull requests.

## Developer

[Helmut](mailto:helmut.savoedo@olade.group)

## Author

[Olade Software](mailto:contact@oladesoftware.com)