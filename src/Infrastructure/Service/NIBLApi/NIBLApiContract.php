<?php

namespace App\Infrastructure\Service\NIBLApi;

use App\Domain\Bot;
use App\Domain\SortDto;

interface NIBLApiContract
{
    public function latestPacks(SortDto $sortDto, int $limit = 20): array;

    public function botList(): array;

    public function botPacks(Bot $bot, SortDto $sortDto, int $page = 0): array;

    public function search(SortDto $sortDto, string $query, int $page = 0): array;

    public function searchInBot(Bot $bot, SortDto $sortDto, string $query, int $page = 0): array;
}
