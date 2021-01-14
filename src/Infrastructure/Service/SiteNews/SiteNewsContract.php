<?php

namespace App\Infrastructure\Service\SiteNews;

interface SiteNewsContract
{
    public function getLatestNews(): ?array;
}
