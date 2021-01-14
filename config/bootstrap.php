<?php

use DI\ContainerBuilder;
use Slim\App;

require_once __DIR__.'/../vendor/autoload.php';

$httpsFlag = (require __DIR__.'/https_check.php')();
define("HTTPS_ENABLED", $httpsFlag);

$settings = require __DIR__.'/settings.php';

$containerBuilder = new ContainerBuilder();
'prod' === $settings['env'] && $containerBuilder->enableCompilation($settings['temp'].'/cache');

// Set up dependencies
$containerBuilder->addDefinitions(__DIR__.'/container.php');

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Create App instance
$app = $container->get(App::class);

// Register routes
(require __DIR__.'/routes.php')($app);

// Register middleware
(require __DIR__.'/middleware.php')($app);

if ('prod' === $settings['env']) {
    $routeCollector = $app->getRouteCollector();
    $routeCollector->setCacheFile($settings['temp'].'/cache/routes.php');
}

return $app;
