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

namespace Micro\Plugin\Http\Business\Logger\Formatter;

use Micro\Plugin\Http\Business\Logger\Formatter\Format\HttpRefererFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\IpFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\MethodFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\RequestBodyFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\RequestFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\StatusFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\TimeFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\UsernameFormat;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class LogFormatterFactory implements LogFormatterFactoryInterface
{
    public function create(string $format): LogFormatterInterface
    {
        return new LogFormatter(
            [
                new HttpRefererFormat(),
                new IpFormat(),
                new MethodFormat(),
                new RequestBodyFormat(),
                new RequestFormat(),
                new StatusFormat(),
                new TimeFormat(),
                new UsernameFormat(),
            ],
            $format
        );
    }
}
