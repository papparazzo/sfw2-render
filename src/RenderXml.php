<?php

namespace SFW2\Render;

use Handlebars\Handlebars;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class RenderXml implements RenderInterface
{
    public function __construct(
        private readonly Handlebars $handlebars,
        private readonly bool $appendAttributes = false
    ) {
    }

    /**
     * @param  Request              $request
     * @param  Response             $response
     * @param  array<string, mixed> $data
     * @param  string|null          $template
     * @return Response
     */
    public function render(Request $request, Response $response, array $data = [], ?string $template = null): Response
    {
        $data = $this->appendAttributes ? array_merge($request->getAttributes(), $data) : $data;
        $payload =
            '<?xml version="1.0" encoding="utf-8"?>' . PHP_EOL .
            '<div>' .
            $this->handlebars->render((string)$template, $data) .
            '</div>';

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'text/xml');
    }
}