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

namespace Micro\Plugin\Http\Business\Formatter\Format;

use Micro\Plugin\Http\Business\Formatter\LogFormatterInterface;
use Micro\Plugin\Http\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
abstract class AbstractFormat implements LogFormatterInterface
{
    public function __construct(
        private readonly string $formatString
    ) {
    }

    public function format(Request $request, Response|null $response, ?HttpException $exception): string
    {
        $var = '{{'.$this->getVarName().'}}';

        if (!str_contains($this->formatString, $var)) {
            return $this->formatString;
        }

        return str_ireplace(
            $var,
            $this->formatString,
            $this->getVarValue($request, $response, $exception)
        );
    }

    abstract protected function getVarValue(Request $request, Response $response, ?HttpException $exception): string;

    abstract protected function getVarName(): string;
}
