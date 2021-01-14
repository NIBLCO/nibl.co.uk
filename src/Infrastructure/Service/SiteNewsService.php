<?php

namespace App\Infrastructure\Service;

use App\Domain\SiteNews;
use App\Infrastructure\Service\SiteNews\SiteNewsContract;

final class SiteNewsService
{
    private SiteNewsContract $newsContract;

    public function __construct(SiteNewsContract $newsContract)
    {
        $this->newsContract = $newsContract;
    }

    public function getLatestNews(): ?SiteNews
    {
        if (! $data = $this->newsContract->getLatestNews()) {
            return null;
        }

        return SiteNews::fromData($data);
    }
}
