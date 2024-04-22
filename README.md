# PHP Router

[![Latest Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://github.com/oladesoftware/router)
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
- **Grouped route configuration**: Easily configure many routes that have a same basepath with HTTP methods, paths, and targets
- **Middleware Support**: Assign middleware to routes for additional processing.
- **Dynamic Path Parameters**: Define paths with placeholders to capture dynamic values.
- **Route Matching**: Match requested paths and methods against configured routes.
- **Execution of Actions**: Execute actions based on matched route details.

## Installation

### Download Router.php files

- Go to [Releases section](https://github.com/oladesoftware/router/releases)
- Download the Router.php file
- Place it into your project 
- Include it in your project and instantiate the `Router` class as follows

```php
require_once 'path/to/Router.php';

use Oladesoftware\Router\Router;

// Create a new router instance
$router = new Router();

// Start adding routes and defining your application's behavior.
```
### Use composer

- Install composer
- Execute command below

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

// Add Grouped Route
$router->addGroup("/blog", [
    ["method" => "GET", "path" => "/", "target" => ["controller" => "BlogController", "method" => "index"]],
    ["method" => "GET", "path" => "/posts", "target" => ["controller" => "BlogController", "method" => "posts"], "name" => "blog.posts"]
]);

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

### Add grouped route

```php
$router->addGroup("/blog", [
    ["method" => "GET", "path" => "/", "target" => ["controller" => "BlogController", "method" => "index"]],
    ["method" => "GET", "path" => "/posts", "target" => ["controller" => "BlogController", "method" => "posts"], "name" => "blog.posts"]
]);
```

## License

The Router class is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).

## Contributing

Contributions are welcome! Feel free to submit issues or pull requests.

## Developer

[Helmut](mailto:helmut.savoedo@olade.group)

## Author

[Olade Software](mailto:contact@oladesoftware.com)