<?php

namespace App\Infrastructure\Service\SiteNews;

use App\Infrastructure\Service\Cache\DataCache;
use App\Infrastructure\Service\Cache\ExpireKey;
use Psr\Log\LoggerInterface;

class CachedSiteNewsRepository implements SiteNewsContract
{
    private const LATEST_NEWS_KEY = 'latestNews';

    private LoggerInterface $logger;
    private PDOSiteNewsRepository $newsRepository;
    private DataCache $dataCache;

    public function __construct(LoggerInterface $logger, PDOSiteNewsRepository $newsRepository, DataCache $dataCache)
    {
        $this->logger = $logger;
        $this->newsRepository = $newsRepository;
        $this->dataCache = $dataCache;
    }

    public function getLatestNews(): ?array
    {
        if ($dataRaw = $this->dataCache->getItem(self::LATEST_NEWS_KEY)) {
            return json_decode($dataRaw, true);
        }

        $data = $this->newsRepository->getLatestNews();
        if (null === $data) {
            return null;
        }

        $this->dataCache->setItem(self::LATEST_NEWS_KEY, json_encode($data), ExpireKey::EXPIRE_IN_10_MIN);

        return $data;
    }
}
