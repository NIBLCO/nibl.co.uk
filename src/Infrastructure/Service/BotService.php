<?php

namespace App\Infrastructure\Service;

use App\Domain\Bot;
use App\Exception\AppException;
use App\Infrastructure\Service\NIBLApi\NIBLApiContract;

final class BotService
{
    private NIBLApiContract $apiClient;

    public function __construct(NIBLApiContract $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @throws AppException
     */
    public function findByName(string $name): ?Bot
    {
        try {
            $rawData = $this->apiClient->botList();
            foreach ($rawData['content'] as $data) {
                if ($data['name'] === $name) {
                    return Bot::fromRequest($data);
                }
            }

            return null;
        } catch (\Exception $exception) {
            throw new AppException($exception->getMessage());
        }
    }

    /**
     * @return Bot[]
     * @throws AppException
     */
    public function listAll(): array
    {
        try {
            $rawData = $this->apiClient->botList();

            return Bot::fromRawCollection($rawData['content']);
        } catch (\Exception $exception) {
            throw new AppException($exception->getMessage());
        }
    }
}
