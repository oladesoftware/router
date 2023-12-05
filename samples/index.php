<?php

require(dirname(__DIR__) . "/vendor/autoload.php");
require(__DIR__ . "/Welcome.php");

use Oladesoftware\Router\Router;

$router = new Router();

// REGISTER A ROUTE
$router->addRoute("GET", "/", ["controller" => "Welcome", "method" => "sayHello"]);
$router->addRoute("GET|POST", "/hi", function (){
    echo "Hi!";
}, "hi");
$router->addRoute("GET", "/hello/(?<name>[a-zA-Z]+)", function ($name){
    echo "Hello, $name!";
}, "sayHello")->middleware("authentificated");

// GET PATH FROM REQUEST_URI AND METHOD FROM REQUEST_METHOD
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];

// GET ARRAY OF MATCHED ROUTE PATH AND METHOD FROM REGISTER
$match = $router->match($path, $method);

// TREATMENT OF NOT FOUND REQUEST
if(!$match){
    http_response_code(404);
    echo "404 NOT FOUND";
    exit();
}

// IF ROUTE HAS MIDDLEWARE, THEN MAKE YOUR OWN LOGIC
// [FOR DOCUMENTING PURPOSE]
if(isset($match["middleware"])){
    switch ($match["middleware"]){
        case "authentificated":
            if(session_status() === PHP_SESSION_DISABLED){
                session_start();
            }
            if(!isset($_SESSION["isAuthentificated"])){
                http_response_code(401);
                echo "Access not granted";
                exit();
            }
            break;
        default:
            http_response_code(401);
            echo "Access not granted";
            exit();
    }
}

// PROCESS ROUTE
$router->run($match);