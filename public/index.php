<?php

session_start();

use Dotenv\Dotenv;
use CoffeeCode\Router\Router;

require __DIR__ . "./../vendor/autoload.php";

Dotenv::createImmutable(__DIR__ . "./../")->load();

$router = new Router($_ENV["DOMAIN"], "::");

$router->namespace("App\Controller");

/**
* Web Routes
*/
$router->group("/");
$router->get("/", "WebController::index");

/**
* User Routes
*/
$router->get("/login", "UserController::login");
$router->post("/login", "UserController::login");
$router->get("/logout", "UserController::logout");

$router->get("/register", "UserController::register");
$router->post("/register", "UserController::register");

$router->get("/nicknakeExist", "UserController::nickname");
$router->get("/emailExist", "UserController::email");

/**
 * This method executes the routes
 */
$router->dispatch();

if($router->error()){
    var_dump($router->error());
}
