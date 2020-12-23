<?php

use Dotenv\Dotenv;
use CoffeeCode\Router\Router;

require __DIR__ . "./../vendor/autoload.php";

Dotenv::createImmutable(__DIR__ . "./../")->load();

$router = new Router($_ENV["DOMAIN"], "::");

$router->namespace("App\Controller");

$router->group("/");
$router->get("/", "WebController::index");

/**
 * This method executes the routes
 */
$router->dispatch();
