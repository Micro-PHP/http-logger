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

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\ConfigurableInterface;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginConfigurationTrait;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Plugin\Http\Business\Executor\HttpExecutorLoggerAwareDecoratorFactory;
use Micro\Plugin\Http\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterFactory;
use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterFactoryInterface;
use Micro\Plugin\Http\Decorator\HttpFacadeLoggerDecorator;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Logger\LoggerFacadeInterface;
use Micro\Plugin\Logger\LoggerPlugin;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 *
 * @method PluginHttpLoggerConfigurationInterface configuration()
 */
class PluginHttpLogger implements DependencyProviderInterface, PluginDependedInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;
    private HttpFacadeInterface $httpFacade;
    private LoggerFacadeInterface $loggerFacade;

    public function provideDependencies(Container $container): void
    {
        $container->decorate(HttpFacadeInterface::class, function (
            HttpFacadeInterface $httpFacade,
            LoggerFacadeInterface $loggerFacade
        ) {
            $this->httpFacade = $httpFacade;
            $this->loggerFacade = $loggerFacade;

            return $this->createDecorator();
        });
    }

    protected function createDecorator(): HttpFacadeInterface
    {
        return new HttpFacadeLoggerDecorator(
            $this->httpFacade,
            $this->createHttpExecutorFactory()
        );
    }

    protected function createHttpExecutorFactory(): RouteExecutorFactoryInterface
    {
        return new HttpExecutorLoggerAwareDecoratorFactory(
            $this->httpFacade,
            $this->loggerFacade,
            $this->createLogFormatterFactory(),
            $this->configuration()
        );
    }

    protected function createLogFormatterFactory(): LogFormatterFactoryInterface
    {
        return new LogFormatterFactory();
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
            LoggerPlugin::class,
        ];
    }
}
