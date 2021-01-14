<?php

namespace App\Infrastructure\Service\NIBLApi;

use App\Domain\Bot;

interface NIBLApiContract
{
    public function latestPacks(int $limit = 20): array;

    public function botList(): array;

    public function botPacks(Bot $bot, int $page = 0): array;

    public function search(string $query): array;

    public function searchInBot(Bot $bot, string $query): array;
}
