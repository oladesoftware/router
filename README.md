# PHP Router

[![Latest Version](https://img.shields.io/badge/version-1.1.0-blue.svg)](https://github.com/oladesoftware/router)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)

A simple lightweight router implementation for handling HTTP routes written in PHP.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [License](#license)
- [Contributing](#contributing)
- [Contributors](#contributors)
- [Author](#author)

## Features

- **Route Configuration**: Easily configure routes with HTTP methods, paths, and targets.
- **Grouped route configuration**: Easily configure many routes that have a same basepath.
- **Middleware Support**: Add middleware to route for additional processing.
- **Dynamic Path Parameters**: Define path with placeholder to capture dynamic values.
- **Route Matching**: Match requested path and method against configured routes.
- **Execution of Actions**: Execute actions based on matched route details.

## Installation

### Download Router.php files

- Go to [Releases section](https://github.com/oladesoftware/router/releases)
- Download the Router.php file
- Place it into your project 
- Include it in your project and instantiate the `Router` class as follows

```php
require_once('path/to/Router.php');

use Oladesoftware\Router\Router;

// Get an instance of the router
$router = Router::getInstance();

// Start adding routes and defining your application's behavior.
```
### Use composer

- Install composer
- Execute command below

```php
composer require oladesoftware/router
```

## Usage

```php
use Oladesoftware\Router\Router;
```

### Get an instance of the router

```php
$router = Router::getInstance();
```

### Add a route

```php
$router->addRoute('GET', '/example', ['controller' => 'ExampleController', 'method' => 'index']);
$router->addRoute('GET', '/example', ['ExampleController', 'index']);
$router->addRoute('GET', '/example', 'ExampleController@index');
$router->addRoute('GET', '/example', function(){});
```

### Adding a Named Route

```php
$router->addRoute('GET', '/home', ['controller' => 'HomeController', 'method' => 'index'], 'home');
```

### Add Grouped Route

```php
$router->addGroup("/blog", [
    ["method" => "GET", "path" => "/", "target" => ["controller" => "BlogController", "method" => "index"]],
    ["method" => "GET", "path" => "/posts", "target" => ["BlogController", "posts"], "name" => "blog.posts"],
    ["GET", "/posts", "BlogController@posts", "blog.posts"]
]);
```

### Match a requested path and method

```php
$result = $router->match('/example', 'GET');
```

### Execute the matched action

```php
$response = $router->run($result);
```

### Middleware Usage

```php
// Add a route with middleware
$router->addRoute('GET', '/authenticated', ['controller' => 'AuthController', 'method' => 'index'])
       ->middleware('auth');
```

## License

[MIT License](https://opensource.org/licenses/MIT)

## Contributing

Contributions are welcome! Feel free to submit issues or pull requests.

## Contributors

- [Helmut](https://github.com/ahokponou)

## Author

[Olade Software](https://oladesoftware.com)