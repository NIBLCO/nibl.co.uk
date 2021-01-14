<?php

namespace App\Infrastructure\Service;

use App\Domain\Bot;
use App\Domain\Pack;
use App\Infrastructure\Service\NIBLApi\NIBLApiContract;
use App\Infrastructure\Transformer\PackTransformer;

final class PackService
{
    private NIBLApiContract $apiClient;
    private BotService $botService;
    private PackTransformer $packTransformer;

    public function __construct(NIBLApiContract $apiClient, BotService $botService, PackTransformer $packTransformer)
    {
        $this->apiClient = $apiClient;
        $this->botService = $botService;
        $this->packTransformer = $packTransformer;
    }

    /**
     * @return Pack[]
     */
    public function latest(int $limit = 20): array
    {
        $bots = $this->botService->listAll();
        $rawData = $this->apiClient->latestPacks($limit);

        return $this->packTransformer->transform($bots, $rawData['content']);
    }

    /**
     * @return Pack[]
     */
    public function search(string $query): array
    {
        $bots = $this->botService->listAll();
        $rawData = $this->apiClient->search($query);

        return $this->packTransformer->transform($bots, $rawData['content']);
    }

    /**
     * @return Pack[]
     */
    public function searchInBot(Bot $bot, string $query): array
    {
        $rawData = $this->apiClient->searchInBot($bot, $query);

        return $this->packTransformer->transform([$bot], $rawData['content']);
    }

    /**
     * @return Pack[]
     */
    public function latestBotPacks(Bot $bot, int $page): array
    {
        $rawData = $this->apiClient->botPacks($bot, $page);

        return $this->packTransformer->transform([$bot], $rawData['content']);
    }
}
