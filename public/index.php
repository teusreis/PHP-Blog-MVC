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
 * Post Routes
 */
$router->group("post");
$router->get("/myPost", "PostController::index");
$router->get("/search", "PostController::search");
$router->get("/show/{id}", "PostController::show");
$router->get("/create", "PostController::create");
$router->post("/create", "PostController::create");
$router->get("/update/{id}", "PostController::update");
$router->post("/update", "PostController::update");
$router->delete("/delete", "PostController::delete");

/**
 * Faker Routes
 */
$router->group("faker");
$router->get("/users/{qtd}", "FakerController::users");
$router->get("/posts/{id}/{qtd}", "FakerController::posts");

/**
 * This method executes the routes
 */
$router->dispatch();

if ($router->error()) {
    var_dump($router->error());
}
