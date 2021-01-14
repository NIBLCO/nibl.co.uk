<?php

namespace App\Action;

use App\Infrastructure\Service\BotService;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ShowBotsAction extends AbstractAction
{
    private BotService $botService;

    public function __construct(Responder $responder, BotService $botService)
    {
        parent::__construct($responder);
        $this->botService = $botService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->responder->render($response, 'bots.html.twig', ['bots' => $this->botService->listAll()]);
    }
}
