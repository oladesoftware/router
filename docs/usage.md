# Usage

## Initializing the router

To get an instance of the router, use the `getInstance` method.

```php
use Oladesoftware\Router\Router;

$router = Router::getInstance();
```

## Add a route

You can add routes using the addRoute method. This method supports defining HTTP methods, URI paths, and targets.

```php
$router->addRoute('GET', '/example', ['controller' => 'ExampleController', 'method' => 'index']);
$router->addRoute('GET', '/example', ['ExampleController', 'index']);
$router->addRoute('GET', '/example', 'ExampleController@index');
$router->addRoute('POST', '/submit', function(){
    // Handle the form submission
}, 'submitForm');
```

## Add Grouped Route

To add multiple routes under a common base path, use the `addGroup` method.

```php
$router->addGroup('/blog', [
    ['GET', '/', [BlogController::class, 'index'], 'blog.index'],
    ['GET', '/post', 'BlogController@post', 'blog.post']
]);
```

## Middleware Usage

Assign middleware to the last added route using the middleware method.

```php
$router
    ->addRoute('GET', '/dashboard', ['DashboardController@index'])
    ->middleware('auth');
```

## Generating Named Routes

You can generate the path for a named route using the generatePath method.

```php
$path = $router->generatePath('home'); // Returns '/home'
```

## Matching Routes

Match an incoming request to the defined routes using the match method. This method returns the matched route details or false if no match is found.

```php
$requestPath = '/home';
$requestMethod = 'GET';
$route = $router->match($requestPath, $requestMethod);

if (!$route) {
    // Handle 404 not found
} else {
    // Handle the matched route
    $router->run($route);
}
```