<?php

/**
 *  SFW2 - SimpleFrameWork
 *
 *  Copyright (C) 2025  Stefan Paproth
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU Affero General Public License as
 *  published by the Free Software Foundation, either version 3 of the
 *  License, or (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *  GNU Affero General Public License for more details.
 *
 *  You should have received a copy of the GNU Affero General Public License
 *  along with this program. If not, see <http://www.gnu.org/licenses/agpl.txt>.
 *
 */

declare(strict_types=1);

namespace SFW2\Render\Conditions;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class MatchesAcceptHeader implements ConditionInterface
{
    public const string MEDIA_XML = 'application/xml';
    public const string MEDIA_JSON = 'application/json';
    public const string MEDIA_TEXT = 'text/plain';
    public const string MEDIA_CSV = 'text/csv';
    public const string MEDIA_HTML = 'text/html';

    public function __construct(
        private readonly string $media
    ) {
        if (!preg_match("#[a-z]{3,}/[a-z]{3,}#", $this->media)) {
            throw new InvalidArgumentException("The media '$this->media' is not a valid media type.");
        }
    }

    public function __invoke(Request $request, Response $response): bool
    {
        $accept = $request->getHeaderLine('Accept');

        if (preg_match("#\*/\*#", $accept)) {
            return true;
        }

        $pos = strpos($accept, '/');
        $res = substr($accept, 0, $pos);
        $res = "$res/*";

        if (preg_match("#$this->media#", $res)) {
            return true;
        }

        if (preg_match("#$this->media#", $accept)) {
            return true;
        }
        return false;
    }
}