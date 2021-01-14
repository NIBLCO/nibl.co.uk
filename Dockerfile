FROM php:8.0-apache

RUN apt-get update && \
    apt-get -y install git zip libzip-dev wget \
        zlib1g-dev unzip libpq-dev git-core \
        libmcrypt-dev vim libfcgi0ldbl gnupg libbz2-dev \
        libfreetype6-dev libjpeg62-turbo-dev bzip2 libpng-dev \
        libicu-dev libonig-dev libxml2-dev libcurl4-openssl-dev

RUN pecl bundle -d /usr/src/php/ext apcu \
    && docker-php-ext-install -j$(nproc) apcu bcmath iconv mbstring zip bz2 pdo pdo_mysql simplexml sockets exif curl gd \
    && rm /usr/src/php/ext/*.tgz \
    # Install composer
    && EXPECTED_COMPOSER_SIGNATURE=$(wget -q -O - https://composer.github.io/installer.sig) \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '${EXPECTED_COMPOSER_SIGNATURE}') { echo 'Composer.phar Installer verified'; } else { echo 'Composer.phar Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN docker-php-ext-configure opcache --enable-opcache

# Modify default apache configuration
COPY ./etc/docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Use the default PHP production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Custom PHP adjustments (zz to make them the last being applied)
COPY ./etc/docker/php.ini.local $PHP_INI_DIR/conf.d/zz-usln.ini

RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . .

# Composer install stuff
RUN composer install --prefer-dist --no-interaction --no-dev -a \
  # Delete cache directory to reduce size of image
  && rm -rf ~/.composer/cache \
  && composer dump-autoload --no-dev -a

RUN chown -R www-data:www-data ./

EXPOSE 80

CMD ["/var/www/html/etc/docker/start-apache"]
