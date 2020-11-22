<?php

    require_once "vendor/autoload.php";
    require_once "core/views_render.php";
    require_once "config/router.php";

    use \Core\Route;
    use \Core\Database;

    new Database();
    $router = new Route();
    $router->set($routes);
