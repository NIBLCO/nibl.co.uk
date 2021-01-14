<?php

// Error reporting for production
error_reporting(1);
ini_set('display_errors', '1');
ini_set('session.gc_maxlifetime', '43200'); // 12h session timeout

// Timezone
date_default_timezone_set('UTC');

// Settings
$settings = [];
$settings['env'] = false === getenv('APPLICATION_ENVIRONMENT') ? 'dev' : getenv('APPLICATION_ENVIRONMENT');
$settings['version'] = '0.1.0';

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['etc'] = sprintf('%s/etc', $settings['root']);
$settings['temp'] = sprintf('%s/var', $settings['root']);
$settings['public'] = sprintf('%s/public', $settings['root']);

// Error Handling Middleware settings
$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => 'prod' !== $settings['env'],

    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true,
];

$settings['logger'] = [
    'name' => 'app',
    'path' => sprintf('%s/logs/%s.log', $settings['temp'], $settings['env']),
    'level' => 'dev' === $settings['env'] ? \Monolog\Logger::DEBUG : \Monolog\Logger::INFO,
];

$settings['twig'] = [
    'templates' => sprintf('%s/templates', $settings['root']),
    'debug' => 'prod' !== $settings['env'],
    'cache' => 'prod' === $settings['env'] ? sprintf('%s/cache/twig', $settings['temp']) : false,
];

$settings['cache'] = [
    'type' => 'public',
    'maxAge' => 86400,
];

$settings['session'] = [
    'name' => 'nibl-web',
    // Lax will sent the cookie for cross-domain GET requests
    'cookie_samesite' => 'Lax',
    // Optional: Sent cookie only over https
    'cookie_secure' => HTTPS_ENABLED,
    // Optional: Additional XSS protection
    // Note: The cookie is not accessible for JavaScript!
    'cookie_httponly' => true,
];

$settings['dataCache'] = 'apcu'; # or redis

$settings['redis'] = [
    'host' => 'localhost',
    'port' => 6379,
    'prefix' => 'nibl',
];

$settings['botAPI'] = [
    'uri' => 'https://api.nibl.local:8080/nibl/',
];

$settings['db'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'port' => 3306,
    'username' => 'CHANGE_ME',
    'database' => 'CHANGE_ME',
    'password' => 'CHANGE_ME',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci',
    ],
];

require $settings['root'].'/config/settings.local.php';

return $settings;
