<?php

namespace App\Action;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractAction
{
    protected Responder $responder;

    public function __construct(Responder $responder)
    {
        $this->responder = $responder;
    }

    abstract public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface;
}
