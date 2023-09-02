<?php

namespace App\Action;

use App\Domain\BotQueryDto;
use App\Infrastructure\Service\BotService;
use App\Infrastructure\Service\PackService;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

final class ShowBotAction extends AbstractAction
{
    private BotService $botService;
    private PackService $packService;

    public function __construct(Responder $responder, BotService $botService, PackService $packService)
    {
        parent::__construct($responder);
        $this->botService = $botService;
        $this->packService = $packService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        if (! $bot = $this->botService->findByName($args['name'])) {
            throw new HttpNotFoundException($request, 'Bot not found');
        }

        $results = null;
        $lastPacks = null;
        $botQuery = BotQueryDto::fromRequest($request->getQueryParams());

        if (true === $botQuery->getQueryDto()->isValid()) {
            $results = $this->packService->searchInBot($bot, $botQuery);
        } else {
            $lastPacks = $this->packService->latestBotPacks($bot, $botQuery);
        }

        return $this->responder->render(
            $response,
            'bot.html.twig',
            [
                'bot' => $bot,
                'query' => $botQuery->getQueryDto()->getValue(),
                'results' => $results,
                'lastPacks' => $lastPacks,
                'previousPageNumber' => $botQuery->previousPageNumber(),
                'nextPageNumber' => $botQuery->nextPageNumber(),
            ]
        );
    }
}
