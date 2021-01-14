<?php

/* Check if current connection is secured by HTTPS, it handles standard setup and HaProxy scenario */
return static function () {
    if (isset($_SERVER['HTTPS']) && 'on' === strtolower($_SERVER['HTTPS'])) {
        return true;
    }

    if ((! empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'])
        || (! empty($_SERVER['HTTP_X_FORWARDED_SSL']) && 'on' === $_SERVER['HTTP_X_FORWARDED_SSL'])) {
        define('HTTPS_ENABLED', true);

        return true;
    }

    return true;
};
