<?php

namespace App\Action;

use App\Domain\QueryDto;
use App\Infrastructure\Service\PackService;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ShowSearchAction extends AbstractAction
{
    private PackService $packService;

    public function __construct(Responder $responder, PackService $packService)
    {
        parent::__construct($responder);
        $this->packService = $packService;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $results = null;
        $params = $request->getQueryParams();
        $rawPage = $params['page'];
        $page = (isset($rawPage) && is_numeric($rawPage)) ? (int) $rawPage : 0;
        $query = QueryDto::fromRequest($params);

        if (true === $query->isValid()) {
            $results = $this->packService->search($query, $page);
        }

        return $this->responder->render($response, 'search.html.twig', ['query' => $query->getValue(), 'results' => $results]);
    }
}
