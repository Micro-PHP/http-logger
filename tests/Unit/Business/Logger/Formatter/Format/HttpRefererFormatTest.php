<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Business\Logger\Formatter\Format;

use Micro\Plugin\Http\Business\Logger\Formatter\Format\HttpRefererFormat;

class HttpRefererFormatTest extends AbstractFormatTest
{
    protected function getTestClass(): string
    {
        return HttpRefererFormat::class;
    }

    public function getVariable(): string
    {
        return 'http_referer';
    }

    public function assertResult(mixed $object, mixed $result)
    {
        $this->assertEquals('hello - ', $result);
    }
}
