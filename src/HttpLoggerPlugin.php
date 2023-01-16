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
use Micro\Plugin\Http\Business\Logger\Formatter\Format\HeadersRequestFormatter;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\IpFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\MethodFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\RequestBodyFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\RequestFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\StatusFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\TimeFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\Format\UsernameFormat;
use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterFactory;
use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterFactoryInterface;
use Micro\Plugin\Http\Decorator\HttpFacadeLoggerDecorator;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Logger\Facade\LoggerFacadeInterface;
use Micro\Plugin\Logger\LoggerPlugin;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 *
 * @method HttpLoggerPluginConfigurationInterface configuration()
 *
 * @codeCoverageIgnore
 */
class HttpLoggerPlugin implements DependencyProviderInterface, PluginDependedInterface, ConfigurableInterface
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
        }, $this->configuration()->getWeight()
        );
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
        return new LogFormatterFactory(
            [
                new HeadersRequestFormatter($this->configuration()->getRequestHeadersSecuredList()),
                new IpFormat(),
                new MethodFormat(),
                new RequestBodyFormat(),
                new RequestFormat(),
                new StatusFormat(),
                new TimeFormat(),
                new UsernameFormat(),
            ]
        );
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
            LoggerPlugin::class,
        ];
    }
}
