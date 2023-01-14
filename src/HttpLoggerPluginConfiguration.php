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

namespace Micro\Plugin\Http;

use Micro\Framework\Kernel\Configuration\PluginConfiguration;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpLoggerPluginConfiguration extends PluginConfiguration implements HttpLoggerPluginConfigurationInterface
{
    public const CFG_LOGGER_ACCESS = 'MICRO_HTTP_LOGGER_ACCESS';
    public const CFG_LOGGER_ERROR = 'MICRO_HTTP_LOGGER_ERROR';
    public const CFG_DECORATION_WEIGHT = 'MICRO_HTTP_LOGGER_DECORATION_WEIGHT';

    public const CFG_HTTP_LOGGER_ACCESS_FORMAT = 'MICRO_HTTP_LOGGER_ACCESS_FORMAT';
    public const CFG_HTTP_LOGGER_ERROR_FORMAT = 'MICRO_HTTP_LOGGER_ERROR_FORMAT';
    public const LOGGER_ERROR_FORMAT_DEFAULT = '{{remote_addr}} - {{remote_user}} [{{time}}] "{{request}}" {{status}}';
    public const LOGGER_ACCESS_FORMAT_DEFAULT = '{{remote_addr}} - {{remote_user}} [{{time}}] "{{request}}" {{status}} {{http_referer}} {{http_user_agent}}';

    public const DECORATION_DEFAULT = 10;

    public function getAccessLoggerName(): string|null
    {
        return $this->configuration->get(self::CFG_LOGGER_ACCESS);
    }

    public function getErrorLoggerName(): string|null
    {
        return $this->configuration->get(self::CFG_LOGGER_ERROR);
    }

    public function getWeight(): int
    {
        return (int) $this->configuration->get(self::CFG_DECORATION_WEIGHT, self::DECORATION_DEFAULT, false);
    }

    public function getErrorLogFormat(): string
    {
        return $this->configuration->get(self::CFG_HTTP_LOGGER_ERROR_FORMAT, self::LOGGER_ERROR_FORMAT_DEFAULT, false);
    }

    public function getAccessLogFormat(): string
    {
        return $this->configuration->get(self::CFG_HTTP_LOGGER_ACCESS_FORMAT, self::LOGGER_ACCESS_FORMAT_DEFAULT, false);
    }
}
