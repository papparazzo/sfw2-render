<?php

namespace SFW2\Render;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface RenderInterface
{
    public function render(Request $request, Response $response, array $data = [], ?string $template = null): Response;
}