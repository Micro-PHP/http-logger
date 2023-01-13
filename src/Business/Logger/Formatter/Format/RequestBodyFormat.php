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

namespace Micro\Plugin\Http\Business\Logger\Formatter\Format;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RequestBodyFormat extends AbstractFormat
{
    protected function getVarValue(Request $request, Response|null $response, ?\Throwable $exception): string
    {
        $type = (string) $request->headers->get('Content-Type');

        switch ($type) {
            case 'application/EDI-X12':
            case 'application/javascript':
            case 'application/EDIFACT':
            case 'application/xhtml+xml':
                return sprintf('~%s Content~', $this->getTypeFrontName($type));
            case 'application/zip':
                return '~ZIP Binary~';
            case 'application/x-shockwave-flash':
                return '~FLASH Binary~';
            case 'application/pdf':
                return '~PDF Binary~';
            case 'application/ogg':
                return 'OGG Binary';
            case 'audio/mpeg':
            case 'audio/x-ms-wma':
            case 'audio/vnd.rn-realaudio':
            case 'audio/x-wav':
                return sprintf('~Audio %s content~', $this->getTypeFrontName($type));
            case 'application/vnd.oasis.opendocument.text':
            case 'application/vnd.oasis.opendocument.spreadsheet':
            case 'application/vnd.oasis.opendocument.presentation':
            case 'application/vnd.oasis.opendocument.graphics':
            case 'application/vnd.ms-excel':
            case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            case 'application/vnd.ms-powerpoint':
            case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
            case 'application/msword':
            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            case 'application/vnd.mozilla.xul+xml':
                return sprintf('~VND %s~', $this->getTypeFrontName($type));
            case 'video/mpeg':
            case 'video/mp4':
            case 'video/quicktime':
            case 'video/x-ms-wmv':
            case 'video/x-msvideo':
            case 'video/x-flv':
            case 'video/webm':
                return sprintf('~Video %s~', $this->getTypeFrontName($type));
            case 'multipart/form-data':
            case 'multipart/mixed':
            case 'multipart/alternative':
            case 'multipart/related':
                return sprintf('~Multipart %s~', $this->getTypeFrontName($type));
            default:
                return $request->getContent();
        }
    }

    protected function getVarName(): string
    {
        return 'request_body';
    }

    private function getTypeFrontName(string $type): string
    {
        $exploded = explode('/', $type);

        return mb_convert_case(array_pop($exploded), \MB_CASE_TITLE);
    }
}
