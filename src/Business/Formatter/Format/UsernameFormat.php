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

use Micro\Plugin\Http\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class UsernameFormat extends AbstractFormat
{
    protected function getVarValue(Request $request, Response|null $response, ?HttpException $exception): string
    {
        return $request->getUser() ?? '';
    }

    protected function getVarName(): string
    {
        return 'remote_user';
    }
}
