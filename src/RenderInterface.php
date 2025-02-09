<?php

namespace SFW2\Render;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface RenderInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param array<string, mixed> $data
     * @param string|null $template
     * @return Response
     */
    public function render(Request $request, Response $response, array $data = [], ?string $template = null): Response;
}