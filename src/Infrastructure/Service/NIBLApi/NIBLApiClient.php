<?php

namespace App\Infrastructure\Service\NIBLApi;

use App\Domain\Bot;
use App\Domain\SortDto;
use App\Exception\NIBLApiException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

final class NIBLApiClient implements NIBLApiContract
{
    private Client $client;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger, string $apiUrl)
    {
        $this->client = new Client([
            'base_uri' => $apiUrl,
            'timeout' => 10.0,
        ]);

        $this->logger = $logger;
    }

    /**
     * @throws NIBLApiException
     */
    public function latestPacks(SortDto $sortDto, int $limit = 20): array
    {
        try {
            $response = $this->client->request('GET', 'latest', ['query' => ['limit' => $limit, 'sort' => $sortDto->getBy(), 'direction' => (string) $sortDto->getDirection()]]);

            return $this->validateResponse($response);
        } catch (GuzzleException $exception) {
            $this->throwFormattedException($exception->getMessage());

            return [];
        }
    }

    /**
     * @throws NIBLApiException
     */
    public function botList(): array
    {
        try {
            $response = $this->client->request('GET', 'bots');

            return $this->validateResponse($response);
        } catch (GuzzleException $exception) {
            $this->throwFormattedException($exception->getMessage());

            return [];
        }
    }

    /**
     * @throws NIBLApiException
     */
    public function botPacks(Bot $bot, SortDto $sortDto, int $page = 0): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('packs/%s/page', $bot->getId()),
                ['query' => ['page' => $page, 'size' => 1000, 'sort' => $sortDto->getBy(), 'direction' => (string) $sortDto->getDirection()]]
            );

            return $this->validateResponse($response);
        } catch (GuzzleException $exception) {
            $this->throwFormattedException($exception->getMessage());

            return [];
        }
    }

    /**
     * @throws NIBLApiException
     */
    public function search(SortDto $sortDto, string $query, int $page = 0): array
    {
        try {
            $response = $this->client->request(
                'GET',
                'search/page',
                ['query' => ['page' => $page, 'size' => 1000, 'query' => $query, 'sort' => $sortDto->getBy(), 'direction' => (string) $sortDto->getDirection()]]
            );

            return $this->validateResponse($response);
        } catch (GuzzleException $exception) {
            $this->throwFormattedException($exception->getMessage());

            return [];
        }
    }

    /**
     * @throws NIBLApiException
     */
    public function searchInBot(Bot $bot, SortDto $sortDto, string $query, int $page = 0): array
    {
        try {
            $response = $this->client->request(
                'GET',
                sprintf('search/%s/page', $bot->getId()),
                ['query' => ['page' => $page, 'size' => 1000, 'query' => $query, 'sort' => $sortDto->getBy(), 'direction' => (string) $sortDto->getDirection()]]
            );

            return $this->validateResponse($response);
        } catch (GuzzleException $exception) {
            $this->throwFormattedException($exception->getMessage());

            return [];
        }
    }

    /**
     * @throws NIBLApiException
     */
    private function throwFormattedException(string $message): void
    {
        $source = 'NIBL Api Proxy Error';
        $formattedResponse = sprintf('%s: %s', $source, $message);
        $this->logger->error($formattedResponse);

        throw new NIBLApiException($source.', please check logs');
    }

    /**
     * @throws NIBLApiException
     */
    private function validateResponse(ResponseInterface $response): array
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            $formattedResponse = sprintf('NIBL Api Proxy Error: %s', $statusCode);
            $this->logger->error($formattedResponse);

            throw new NIBLApiException($formattedResponse, $statusCode);
        }

        $body = json_decode((string) $response->getBody(), true);
        if (! \is_array($body)) {
            $this->logger->error('Wrong response body, cannot decode');

            throw new NIBLApiException('NIBL Api Proxy Error');
        }

        if (! isset($body['content'])) {
            $this->logger->error('Content not returned');

            throw new NIBLApiException('NIBL Api Proxy Error');
        }

        $this->logger->debug(sprintf('NIBL Api Proxy response: %s', json_encode($body)));

        return $body;
    }
}
