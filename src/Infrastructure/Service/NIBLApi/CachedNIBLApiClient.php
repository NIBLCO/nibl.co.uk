<?php

namespace App\Infrastructure\Service\NIBLApi;

use App\Domain\Bot;
use App\Domain\SortDto;
use App\Exception\NIBLApiException;
use App\Infrastructure\Service\Cache\DataCache;
use App\Infrastructure\Service\Cache\ExpireKey;
use Psr\Log\LoggerInterface;

final class CachedNIBLApiClient implements NIBLApiContract
{
    private const LATEST_PACKS_KEY = 'latestPacks';
    private const BOT_LIST_KEY = 'botList';
    private const BOT_PACKS_KEY_PARTIAL = 'botPacks';

    private NIBLApiClient $apiClient;
    private DataCache $dataCache;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, NIBLApiClient $apiClient, DataCache $dataCache)
    {
        $this->apiClient = $apiClient;
        $this->dataCache = $dataCache;
        $this->logger = $logger;
    }

    public function latestPacks(SortDto $sortDto, int $limit = 20): array
    {
        if ($dataRaw = $this->dataCache->getItem(self::LATEST_PACKS_KEY)) {
            return json_decode($dataRaw, true);
        }

        $data = $this->apiClient->latestPacks($sortDto, $limit);
        $this->dataCache->setItem(self::LATEST_PACKS_KEY, json_encode($data), ExpireKey::EXPIRE_IN_10_MIN);

        return $data;
    }

    public function botList(): array
    {
        if ($dataRaw = $this->dataCache->getItem(self::BOT_LIST_KEY)) {
            return json_decode($dataRaw, true);
        }

        $data = $this->apiClient->botList();
        $this->dataCache->setItem(self::BOT_LIST_KEY, json_encode($data), ExpireKey::EXPIRE_IN_10_MIN);

        return $data;
    }

    public function botPacks(Bot $bot, SortDto $sortDto, int $page = 0): array
    {
        if ($dataRaw = $this->dataCache->getItem(sprintf('%s_%s', self::BOT_PACKS_KEY_PARTIAL, $bot->getId()))) {
            return json_decode($dataRaw, true);
        }

        try {
            $data = $this->apiClient->botPacks($bot, $sortDto, $page);
            $this->dataCache->setItem(
                sprintf('%s_%s_%d_%s_%s', self::BOT_PACKS_KEY_PARTIAL, $bot->getId(), $page, (string) $sortDto->getDirection(), $sortDto->getBy()),
                json_encode($data),
                ExpireKey::EXPIRE_IN_10_MIN
            );
        } catch (NIBLApiException $exception) {
            $data = ['content' => []];
            $this->logger->error((string) $exception);
        }

        return $data;
    }

    public function search(SortDto $sortDto, string $query, int $page = 0): array
    {
        return $this->apiClient->search($sortDto, $query, $page);
    }

    public function searchInBot(Bot $bot, SortDto $sortDto, string $query, int $page = 0): array
    {
        return $this->apiClient->searchInBot($bot, $sortDto, $query, $page);
    }
}
