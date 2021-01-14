# nibl.co.uk

Slim 4 & PHP 7.4 based website

## Requirements

* PHP 7.3.X/7.4.X (php-xml, php-json, php-common, php-pdo, php-mysql, php-fpm*, php-curl, php-apcu, php-opcache)
* composer 2.X for installing dependencies
* Apache 2.4.X or NGiNX 1.10+ webserver
* Redis 5.X / PHP APCu (default) for Cache DB
* MySQL 5.5+ for DB
* nodejs 14+ and npm 6+ for local development

## Development

1. `cp config/settings.local.php.example config/settings.local.php`
2. Change local settings if needed.
3. Run `composer install` and `npm install`.
4. Run application via:
    * Symfony binary (https://symfony.com/download): `symfony server:start` (recommended!)
    * Local LAMP / LEMP setup (remember to point root to `/public` folder)
    * Use standard php webserver `php -S localhost:8080 -t public` (slow)
5. Compile changes to frontend code with `npm run dev`. (If you need new classes from tailwindcss you should also run this command before changing template code, output stored in GIT is always minified & purged.)
5. Go to application in your browser.

**IMPORTANT** Before committing new changes to source code, run `composer format` && `composer psalm` && `npm run prod`!

## Production

0. PHP process should have at least 128mb memory limit. 256mb is recommended.
1. `cp config/settings.local.php.example config/settings.local.php`
2. Change local settings if needed. 
3. Run `composer install --no-dev`.
4. Point Apache / NGiNX root to `/public` folder.
5. Remember to set `APPLICATION_ENVIRONMENT` env to `prod` (!). 
   * For Apache uncomment `/public/.htaccess` line 24. 
   * For NGiNX set `fastcgi_param APPLICATION_ENVIRONMENT prod;` in php-fpm configuration.
6. Setup HTTPS & HTTP2 for better performance.

## Docker

1. `cp config/settings.local.php.example config/settings.local.php`
    * Setup url or API based on current docker settings
    * Setup DB settings and URL based on current docker settings
    
2. Build image with `docker build -t nibl-www .`
3. Application expose port 9000 by default. Connect it to other docker images & proxy pass in Apache or NGiNX.

    * Remember to set application environment to `prod` (see Production section).
