<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Plugin\Http\HttpCorePlugin;
use Micro\Plugin\Http\HttpLoggerPlugin;
use Micro\Plugin\Logger\LoggerPlugin;
use PHPUnit\Framework\TestCase;

class HttpLoggerPluginTest extends TestCase
{
    private HttpLoggerPlugin $plugin;

    protected function setUp(): void
    {
        $this->plugin = new HttpLoggerPlugin();
    }

    public function testGetDependedPlugins()
    {
        $this->assertInstanceOf(DependencyProviderInterface::class, $this->plugin);

        $this->assertEquals(
            [
                HttpCorePlugin::class,
                LoggerPlugin::class,
            ],
            $this->plugin->getDependedPlugins());
    }

    public function testProvideDependencies()
    {
        $this->assertInstanceOf(DependencyProviderInterface::class, $this->plugin);

        $container = $this->createMock(Container::class);
        $container
            ->expects($this->once())
            ->method('decorate');

        $this->plugin->provideDependencies($container);
    }
}
