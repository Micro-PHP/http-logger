<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterFactoryInterface;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\HttpLoggerPluginConfigurationInterface;
use Micro\Plugin\Logger\LoggerFacadeInterface;
use PHPUnit\Framework\TestCase;

class HttpExecutorLoggerAwareDecoratorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new HttpExecutorLoggerAwareDecoratorFactory(
            $this->createMock(HttpFacadeInterface::class),
            $this->createMock(LoggerFacadeInterface::class),
            $this->createMock(LogFormatterFactoryInterface::class),
            $this->createMock(HttpLoggerPluginConfigurationInterface::class),
        );

        $this->assertInstanceOf(RouteExecutorInterface::class, $factory->create());
    }
}
