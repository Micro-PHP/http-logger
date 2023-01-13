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

use Micro\Plugin\Http\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class LogFormatter implements LogFormatterInterface
{
    /**
     * @param iterable<LogFormatterInterface> $logFormatterCollection
     */
    public function __construct(
        private iterable $logFormatterCollection
    ) {
    }

    public function format(Request $request, Response|null $response, ?HttpException $exception): string
    {
        $message = '';
        foreach ($this->logFormatterCollection as $formatter) {
            $message = $formatter->format($request, $response, $exception);
        }

        return $message;
    }
}
