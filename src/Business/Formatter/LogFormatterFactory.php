<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Formatter;

use Micro\Plugin\Http\Business\Formatter\Format\HttpRefererFormat;
use Micro\Plugin\Http\Business\Formatter\Format\IpFormat;
use Micro\Plugin\Http\Business\Formatter\Format\MethodFormat;
use Micro\Plugin\Http\Business\Formatter\Format\RequestBodyFormat;
use Micro\Plugin\Http\Business\Formatter\Format\RequestFormat;
use Micro\Plugin\Http\Business\Formatter\Format\StatusFormat;
use Micro\Plugin\Http\Business\Formatter\Format\TimeFormat;
use Micro\Plugin\Http\Business\Formatter\Format\UsernameFormat;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class LogFormatterFactory implements LogFormatterFactoryInterface
{
    public function create(string $format): LogFormatterInterface
    {
        return new LogFormatter(
            $this->createLogFormatters($format)
        );
    }

    protected function createLogFormatters(string $format): iterable
    {
        return [
            new HttpRefererFormat($format),
            new IpFormat($format),
            new MethodFormat($format),
            new RequestBodyFormat($format),
            new RequestFormat($format),
            new StatusFormat($format),
            new TimeFormat($format),
            new UsernameFormat($format),
        ];
    }
}
