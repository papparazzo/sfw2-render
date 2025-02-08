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

namespace SFW2\Render\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use SFW2\Render\Conditions\MatchesAcceptHeader;

class MatchesAcceptHeaderTest extends TestCase
{
    public static function dataProvider(): array
    {
        return [
            ['hallo', MatchesAcceptHeader::MEDIA_CSV, false],
            ['text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', MatchesAcceptHeader::MEDIA_CSV, false],
 ['text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', MatchesAcceptHeader::MEDIA_TEXT, false],

        ];
    }

    #[DataProvider('dataProvider')]
    public function test__invoke(string $header, string $value, bool $expected): void
    {
        $reqMock = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $reqMock->method('getHeaderLine')->willReturn($header);

        $resMock = $this->getMockBuilder(ResponseInterface::class)->getMock();

        $matcher = new MatchesAcceptHeader($value);
        $this::assertSame($expected, $matcher($reqMock, $resMock));
    }
}
