<?php

namespace App\Action;

use App\Domain\SortDto;
use App\Infrastructure\Service\PackService;
use App\Infrastructure\Service\SiteNewsService;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ShowIndexAction extends AbstractAction
{
    private PackService $packService;
    private SiteNewsService $newsService;

    public function __construct(Responder $responder, PackService $packService, SiteNewsService $newsService)
    {
        parent::__construct($responder);
        $this->packService = $packService;
        $this->newsService = $newsService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return $this->responder->render(
            $response,
            'index.html.twig',
            [
                'latest' => $this->packService->latest(SortDto::fromRequest($request->getQueryParams())),
                'news' => $this->newsService->getLatestNews(),
            ]
        );
    }
}
