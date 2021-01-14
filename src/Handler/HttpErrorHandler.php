<?php

namespace App\Handler;

use Exception;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler;
use Slim\Interfaces\CallableResolverInterface;
use Slim\Views\Twig;
use Throwable;

final class HttpErrorHandler extends ErrorHandler
{
    private Twig $twig;

    public function __construct(
        CallableResolverInterface $callableResolver,
        ResponseFactoryInterface $responseFactory,
        Twig $twig,
        ?LoggerInterface $logger = null
    ) {
        parent::__construct($callableResolver, $responseFactory, $logger);
        $this->twig = $twig;
        $this->responseFactory = $responseFactory;
        $this->logger = $logger;
    }

    public const BAD_REQUEST = 'BAD_REQUEST';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    public const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';
    public const FORBIDDEN = 'FORBIDDEN';

    protected function respond(): ResponseInterface
    {
        $exception = $this->exception;
        $statusCode = 500;
        $type = self::SERVER_ERROR;
        $description = 'An internal error has occurred while processing your request.';

        if ($exception instanceof HttpException) {
            $statusCode = (int) $exception->getCode();
            $description = $exception->getMessage();

            if ($exception instanceof HttpNotFoundException) {
                $type = self::RESOURCE_NOT_FOUND;
            } elseif ($exception instanceof HttpMethodNotAllowedException) {
                $type = self::NOT_ALLOWED;
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $type = self::UNAUTHENTICATED;
            } elseif ($exception instanceof HttpForbiddenException) {
                $type = self::FORBIDDEN;
            } elseif ($exception instanceof HttpBadRequestException) {
                $type = self::BAD_REQUEST;
            } elseif ($exception instanceof HttpNotImplementedException) {
                $type = self::NOT_IMPLEMENTED;
            }
        }

        if (
            ! ($exception instanceof HttpException)
            && ($exception instanceof Exception || $exception instanceof Throwable)
            && $this->displayErrorDetails
        ) {
            $description = $exception->getMessage();
        }

        $errorPayload = [
            'error' => [
                'code' => $statusCode,
                'message' => $description,
                'details' => [
                    'type' => $type,
                ],
            ],
        ];

        $response = $this->responseFactory->createResponse($statusCode);

        if ($this->contentType === 'text/html') {
            return $this->respondWithHtml($response, $errorPayload);
        }

        return $this->respondWithJson($response, $errorPayload);
    }

    private function respondWithJson(ResponseInterface $response, array $errorPayload): ResponseInterface
    {
        $payload = \json_encode($errorPayload, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    private function respondWithHtml(ResponseInterface $response, array $errorPayload): ResponseInterface
    {
        return $this->twig->render($response, 'error.html.twig', $errorPayload);
    }

    /** {@inheritDoc} */
    protected function writeToErrorLog(): void
    {
        $renderer = $this->callableResolver->resolve($this->logErrorRenderer);
        $error = $renderer($this->exception, $this->logErrorDetails);
        if ($this->exception instanceof HttpNotFoundException) {
            return;
        }

        if (! $this->displayErrorDetails) {
            $error .= "\nTips: To display error details in HTTP response ";
            $error .= 'set "displayErrorDetails" to true in the ErrorHandler constructor.';
        }
        $this->logError($error);
    }
}
