<?php

namespace App\Infrastructure\Service\Cache;

use Predis\Client;

final class RedisCache implements DataCache
{
    private Client $client;

    public function __construct(string $host, int $port, string $prefix = 'nibl')
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host' => $host,
            'port' => $port,
        ], ['prefix' => sprintf('%s:', $prefix)]);
    }

    public function getItem(string $key): ?string
    {
        return $this->client->get($key);
    }

    public function setItem(string $key, string $value, int $expire = 60): void
    {
        if ($this->client->exists($key) === true) {
            $this->client->del($key);
        }

        $this->client->set($key, $value);
        $this->client->expire($key, $expire);
    }
}
