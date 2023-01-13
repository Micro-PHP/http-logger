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
class PluginHttpLoggerConfiguration extends PluginConfiguration implements PluginHttpLoggerConfigurationInterface
{
    public const CFG_LOGGER_ACCESS = 'MICRO_HTTP_LOGGER_ACCESS';
    public const CFG_LOGGER_ERROR = 'MICRO_HTTP_LOGGER_ERROR';
    public const CFG_DECORATION_WEIGHT = 'MICRO_HTTP_LOGGER_DECORATION_WEIGHT';
    public const CFG_DECORATION_DEFAULT = 10;

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
        return (int) $this->configuration->get(self::CFG_DECORATION_WEIGHT, self::CFG_DECORATION_DEFAULT, false);
    }
}
