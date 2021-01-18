<?php

namespace App\Infrastructure\Service;

use App\Domain\Bot;
use App\Domain\Pack;
use App\Domain\QueryDto;
use App\Domain\BotQueryDto;
use App\Domain\SortDto;
use App\Infrastructure\Transformer\PackTransformer;
use App\Infrastructure\Service\NIBLApi\NIBLApiContract;

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
    public function latest(SortDto $sortDto, int $limit = 20): array
    {
        $bots = $this->botService->listAll();
        $rawData = $this->apiClient->latestPacks($sortDto, $limit);

        return $this->packTransformer->transform($bots, $rawData['content']);
    }

    /**
     * @return Pack[]
     */
    public function search(QueryDto $queryDto, int $page = 0): array
    {
        $bots = $this->botService->listAll();
        $rawData = $this->apiClient->search($queryDto->getSortData(), $queryDto->getValue(), $page);

        return $this->packTransformer->transform($bots, $rawData['content']);
    }

    /**
     * @return Pack[]
     */
    public function searchInBot(Bot $bot, BotQueryDto $botQuery): array
    {
        $rawData = $this->apiClient->searchInBot(
            $bot,
            $botQuery->getQueryDto()->getSortData(),
            $botQuery->getQueryDto()->getValue(),
            $botQuery->getPageNumber()
        );

        return $this->packTransformer->transform([$bot], $rawData['content']);
    }

    /**
     * @return Pack[]
     */
    public function latestBotPacks(Bot $bot, BotQueryDto $botQuery): array
    {
        $rawData = $this->apiClient->botPacks($bot, $botQuery->getQueryDto()->getSortData(), $botQuery->getPageNumber());

        return $this->packTransformer->transform([$bot], $rawData['content']);
    }
}
