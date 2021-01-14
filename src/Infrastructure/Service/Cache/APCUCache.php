<?php


namespace App\Infrastructure\Service\Cache;

final class APCUCache implements DataCache
{
    public function getItem(string $key): ?string
    {
        if (! $data = apcu_fetch($key)) {
            return null;
        }

        return $data;
    }

    public function setItem(string $key, string $value, int $expire = 60): void
    {
        if (apcu_exists($key) === true) {
            apcu_delete($key);
        }

        apcu_add($key, $value, $expire);
    }
}
