<?php
/**
 * Router Class
 *
 * @package Oladesoftware\Router
 * @version 0.0.0-alpha
 * @author Helmut
 * @license MIT License
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Oladesoftware\Router;

use RuntimeException;

/**
 * Class Router
 *
 * A simple router implementation for handling HTTP routes.
 */
class Router{
    /**
     * @var array $routes An array containing the configured routes.
     *
     * This array stores the routes configured in the router. Each route is represented as an associative array
     * with keys 'method' for the HTTP method, 'path' for the URI path, and 'target' for the route's target.
     * Example:
     * [
     *    ['method' => 'GET', 'path' => '/example', 'target' => ['controller' => 'ExampleController, 'method' => 'index'],
     *    ['method' => 'POST', 'path' => '/submit', 'target' => function() { ... }],
     *    // ...
     * ]
     *
     * @access private
    */
    private array $routes = [];
    /**
     * @var array $namedRoutes An array mapping route names to their corresponding paths.
     *
     * This array is used to associate names with specific routes, allowing for easy route generation.
     * Example:
     * ```
     * [
     *    'home' => '/home',
     *    'profile' => '/user/profile',
     *    // ...
     * ]
     * ```
     * @access private
     */
    private array $namedRoutes = [];

    /**
     * Add a new route to the router configuration.
     *
     * @param string $method The HTTP method for the route (e.g., 'GET', 'POST' or 'GET|POST' for multiple methods)
     * @param string $path The URI path for the route, which may include placeholders.
     * @param mixed $target The target of the route, such as a controller class or a closure.
     * @param string|null $name The optional name for the route to be used in route generation.
     * @return self Returns an instance of the router for method chaining
     */
    public function addRoute(string $method, string $path, mixed $target, string $name = null): self
    {
        $this->routes[] = [
            "method" => strtoupper($method),
            "path" => $path,
            "target" => $target
        ];
        if($name){
            if(!array_key_exists($name, $this->namedRoutes)){
                $this->namedRoutes[$name] = $path;
            }
        }
        return $this;
    }

    /**
     * Assign a middleware to the last added route in the router configuration.
     *
     * @param string $name The name of the middleware to be assigned.
     *
     * @return self Returns an instance of the router for method chaining.
     *
     * Example:
     * ```
     * $router->addRoute('GET', '/example', ['controller' => 'ExampleController, 'method' => 'index'])->middleware('auth');
     * ```
     */
    public function middleware(string $name): self
    {
        $this->routes[array_key_last($this->routes)]["middleware"] = $name;
        return $this;
    }

    /**
     * Match a requested path and method against configured routes.
     *
     * @param string $path The requested URI path.
     * @param string $method The requested HTTP method (e.g., 'GET', 'POST').
     *
     * @return array|false Returns an array containing matched route details or false if no match is found.
     *
     * This method iterates over the configured routes and attempts to match the provided URI path and HTTP method.
     * If a match is found, an array is returned with the following keys:
     * - 'target': The target of the matched route, such as a controller class or a closure.
     * - 'params': An associative array of placeholder values extracted from the path.
     * - 'middleware': The middleware assigned to the matched route (if any).
     *
     * If no match is found, the method returns false.
     */
    public function match(string $path, string $method): array|false{
        $params = [];
        foreach($this->routes as $route){

            if(!preg_match("%^(" . $route["method"] . ")$%", strtoupper($method)))
            {
                continue;
            }

            if(preg_match("%^" . $route["path"] . "$%", $path, $params))
            {
                foreach ($params as $key => $item){
                    if(is_numeric($key)){
                        unset($params[$key]);
                    }
                }
                return [
                    "target" => $route["target"],
                    "params" => $params,
                    "middleware" => $route["middleware"] ?? null
                ];
            }
        }

        return false;
    }

    /**
     * Execute the specified action based on the matched route details.
     *
     * @param array $action An array containing details of the matched route, including the target, params, and middleware.
     *
     * @return mixed Returns the result of the executed action.
     *
     * @throws RuntimeException If the target is not a valid callable or an array with "controller" and "method" keys.
     *
     * This method executes the specified action based on the details of the matched route. The action can be a callable
     * (e.g., a closure or a function), or an array specifying a controller and method to be invoked. The method handles
     * different types of targets and their associated parameters.
     */
    public function run(array $action): mixed{
        if(is_callable($action["target"]))
        {
            if(empty($action["params"])){
                return call_user_func($action["target"]);
            }
            return call_user_func_array($action["target"], $action["params"]);
        }
        elseif(is_array($action["target"]))
        {
            if(!(array_key_exists("controller", $action["target"]) && array_key_exists("method", $action["target"])))
            {
                throw new RuntimeException("No key named 'controller' or 'method' provides");
            }
            if(!(class_exists($action["target"]["controller"]) && method_exists($action["target"]["controller"], $action["target"]["method"])))
            {
                throw new RuntimeException("Class {$action["target"]["controller"]} or Method {$action["target"]["method"]} doesn't exist");
            }
            if(empty($action["params"])){
                return call_user_func([new $action["target"]["controller"](), $action["target"]["method"]]);
            }
            return call_user_func([new $action["target"]["controller"](), $action["target"]["method"]], $action["params"]);
        }
        throw new RuntimeException("No valid target is provides");
    }
}