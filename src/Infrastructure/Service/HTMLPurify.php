<?php

namespace App\Infrastructure\Service;

use HTMLPurifier;
use HTMLPurifier_Config;

final class HTMLPurify
{
    public static function purify(string $dirtyHtml)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        return $purifier->purify($dirtyHtml);
    }
}
