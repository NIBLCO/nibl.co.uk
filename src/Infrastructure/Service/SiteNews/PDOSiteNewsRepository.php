<?php

namespace App\Infrastructure\Service\SiteNews;

use PDO;
use Psr\Log\LoggerInterface;

class PDOSiteNewsRepository implements SiteNewsContract
{
    private LoggerInterface $logger;
    private PDO $connection;

    public function __construct(LoggerInterface $logger, PDO $connection)
    {
        $this->logger = $logger;
        $this->connection = $connection;
    }

    public function getLatestNews(): ?array
    {
        $this->logger->debug('Fetching latest news from DB');
        $sql = "SELECT * FROM site_news WHERE sn_published_at IS NOT NULL ORDER BY sn_published_at DESC LIMIT 1";
        $query = $this->connection->query($sql);

        if (! $results = $query->fetch(PDO::FETCH_ASSOC)) {
            return null;
        }

        return $results;
    }
}
