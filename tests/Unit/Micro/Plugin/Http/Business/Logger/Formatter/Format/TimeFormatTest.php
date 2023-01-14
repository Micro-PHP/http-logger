<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Logger\Formatter\Format;

class TimeFormatTest extends AbstractFormatTest
{
    protected function getTestClass(): string
    {
        return TimeFormat::class;
    }

    public function getVariable(): string
    {
        return 'time';
    }
}
