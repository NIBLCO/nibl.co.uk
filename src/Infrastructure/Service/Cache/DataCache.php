<?php

namespace App\Infrastructure\Service\Cache;

interface DataCache
{
    public function getItem(string $key): ?string;

    public function setItem(string $key, string $value, int $expire = 60): void;
}
