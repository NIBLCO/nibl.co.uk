<?php

namespace App\Responder;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\HttpCache\CacheProvider;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;

final class Responder
{
    private bool $hasCache = false;
    private ?string $etag;
    private ?string $expires;
    private string $reason = '';
    private int $options = 0;
    private Twig $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Add reason to response status.
     */
    public function withReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Set flags on json encode.
     */
    public function withOptions(int $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Enable client side cache.
     */
    public function withCache(string $etag, ?string $expiresInterval = null): self
    {
        $this->hasCache = true;
        $this->etag = $etag;
        if (null !== $expiresInterval) {
            $this->expires = (new \DateTime())
                ->add(new \DateInterval($expiresInterval))
                ->format('d-m-Y H:i:s');
        }

        return $this;
    }

    /**
     * Output rendered template.
     *
     * @param ResponseInterface $response The response
     * @param string            $template Template pathname relative to templates directory
     * @param array             $data     Associative array of template variables
     *
     * @return ResponseInterface The response
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(ResponseInterface $response, string $template, array $data = []): ResponseInterface
    {
        return $this->twig->render($response, $template, $data);
    }

    /**
     * Write JSON to the response body.
     *
     * This method prepares the response object to return an HTTP JSON
     * response to the client.
     *
     * @param ResponseInterface $response The response
     * @param mixed $data The data
     * @return ResponseInterface The response
     *
     * @throws \JsonException
     */
    public function json(ResponseInterface $response, $data = null, int $status = 200): ResponseInterface
    {
        $cacheProvider = new CacheProvider();

        if ($this->hasCache) {
            null !== $this->etag && $response = $cacheProvider->withEtag($response, $this->etag);
            null !== $this->expires && $response = $cacheProvider->withExpires($response, $this->expires);
        } else {
            $response = $cacheProvider->denyCache($response);
        }

        null !== $data && $response->getBody()->write((string) json_encode($data, JSON_THROW_ON_ERROR | $this->options));

        return $response->withHeader('Content-Type', 'application/json;charset=utf-8')
            ->withStatus($status, $this->reason);
    }

    /**
     * Redirect to selected route.
     *
     * This method prepares the response object to return an HTTP Redirect with Location header
     * response to the client.
     */
    public function redirect(ServerRequestInterface $request, ResponseInterface $response, string $routeName, int $redirectCode = 302): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor($routeName);

        return $response->withHeader('Location', $url)->withStatus($redirectCode);
    }
}
