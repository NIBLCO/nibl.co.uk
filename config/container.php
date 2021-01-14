<?php

use App\Handler\HttpErrorHandler;
use App\Infrastructure\Service\Cache\APCUCache;
use App\Infrastructure\Service\Cache\DataCache;
use App\Infrastructure\Service\Cache\RedisCache;
use App\Infrastructure\Service\NIBLApi\CachedNIBLApiClient;
use App\Infrastructure\Service\NIBLApi\NIBLApiClient;
use App\Infrastructure\Service\NIBLApi\NIBLApiContract;
use App\Infrastructure\Service\SiteNews\CachedSiteNewsRepository;
use App\Infrastructure\Service\SiteNews\PDOSiteNewsRepository;
use App\Infrastructure\Service\SiteNews\SiteNewsContract;
use Monolog\Logger;
use Odan\Session\Middleware\SessionMiddleware;
use Odan\Session\PhpSession;
use Odan\Session\SessionInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\HttpCache\Cache;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Twig\Extension\DebugExtension;

return [
    'settings' => static function () {
        return require __DIR__.'/settings.php';
    },

    App::class => static function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    SessionInterface::class => static function (ContainerInterface $container) {
        $settings = $container->get('settings')['session'];
        $session = new PhpSession();
        $session->setOptions($settings);

        return $session;
    },

    ResponseFactoryInterface::class => static function (ContainerInterface $container) {
        $app = $container->get(App::class);

        return $app->getResponseFactory();
    },

    LoggerInterface::class => static function (ContainerInterface $container) {
        return $container->get(Logger::class);
    },

    Logger::class => static function (ContainerInterface $container) {
        $settings = $container->get('settings')['logger'];
        $logger = new Monolog\Logger($settings['name']);
        $logger->pushProcessor(new Monolog\Processor\UidProcessor());
        $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));

        return $logger;
    },

    PDO::class => static function (ContainerInterface $container) {
        $settings = $container->get('settings')['db'];

        $host = $settings['host'];
        $port = $settings['port'];
        $dbname = $settings['database'];
        $username = $settings['username'];
        $password = $settings['password'];
        $charset = $settings['charset'];
        $flags = $settings['flags'];
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

        return new PDO($dsn, $username, $password, $flags);
    },

    Twig::class => static function (ContainerInterface $container) {
        $settings = $container->get('settings')['twig'];
        $flash = $container->get(SessionInterface::class)->getFlash();
        $twig = Twig::create($settings['templates'], ['cache' => $settings['cache'], 'debug' => $settings['debug']]);
        $twig->getEnvironment()->addGlobal('flash', $flash);
        if (true === $settings['debug']) {
            $twig->addExtension(new DebugExtension());
        }

        return $twig;
    },

    ErrorMiddleware::class => static function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];
        $callableResolver = $app->getCallableResolver();
        $errorHandler = new HttpErrorHandler(
            $callableResolver,
            $container->get(ResponseFactoryInterface::class),
            $container->get(Twig::class),
            $container->get(Logger::class)
        );

        $errorMiddleware = new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details'],
            $container->get(Logger::class)
        );

        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        return $errorMiddleware;
    },

    Cache::class => static function (ContainerInterface $container) {
        $settings = $container->get('settings')['cache'];

        return new Cache($settings['type'], $settings['maxAge']);
    },

    SessionMiddleware::class => static function (ContainerInterface $container) {
        return new SessionMiddleware($container->get(SessionInterface::class));
    },

    TwigMiddleware::class => static function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer(
            $container->get(App::class),
            Twig::class
        );
    },

    DataCache::class => static function (ContainerInterface $container) {
        $cacheStrategy = $container->get('settings')['dataCache'];
        if ($cacheStrategy === 'redis') {
            $settings = $container->get('settings')['redis'];
            return new RedisCache($settings['host'], $settings['port'], $settings['prefix']);
        }

        return new APCUCache();
    },

    NIBLApiContract::class => static function (ContainerInterface $container) {
        $niblApiClient = new NIBLApiClient(
            $container->get(LoggerInterface::class),
            $container->get('settings')['botAPI']['uri']
        );

        return new CachedNIBLApiClient(
            $container->get(LoggerInterface::class),
            $niblApiClient,
            $container->get(DataCache::class)
        );
    },

    SiteNewsContract::class => static function (ContainerInterface $container) {
        $pdoRepository = new PDOSiteNewsRepository(
            $container->get(LoggerInterface::class),
            $container->get(PDO::class)
        );

        return new CachedSiteNewsRepository(
            $container->get(LoggerInterface::class),
            $pdoRepository,
            $container->get(DataCache::class)
        );
    },
];
