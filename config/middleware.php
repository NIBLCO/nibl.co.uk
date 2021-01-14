<?php

use App\Middleware\RouteNameMiddleware;
use Slim\App;
use Slim\HttpCache\Cache;
use Slim\Views\TwigMiddleware;
use Slim\Middleware\ErrorMiddleware;
use Odan\Session\Middleware\SessionMiddleware;

return static function (App $app) {
    // Parse json, form data and xml
    $app->addBodyParsingMiddleware();

    // Add twig route name middleware
    $app->add(RouteNameMiddleware::class);

    // Add twig
    $app->add(TwigMiddleware::class);

    // Cache middleware
    $app->add(Cache::class);

    // Session middleware
    $app->add(SessionMiddleware::class);

    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();

    // Catch exceptions and errors
    $app->add(ErrorMiddleware::class);
};
