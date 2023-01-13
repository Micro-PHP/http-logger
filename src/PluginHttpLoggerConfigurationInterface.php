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

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface PluginHttpLoggerConfigurationInterface
{
    public function getAccessLoggerName(): string|null;

    public function getErrorLoggerName(): string|null;

    public function getErrorLogFormat(): string;

    public function getAccessLogFormat(): string;

    public function getWeight(): int;
}
