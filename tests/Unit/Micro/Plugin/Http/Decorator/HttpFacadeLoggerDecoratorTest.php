<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Decorator;

use Micro\Plugin\Http\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteBuilderInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpFacadeLoggerDecoratorTest extends TestCase
{
    private HttpFacadeInterface $facade;
    private Request $request;

    protected function setUp(): void
    {
        $this->request = $this->createMock(Request::class);
        $decorated = $this->createMock(HttpFacadeInterface::class);
        $routeExecutorFactory = $this->createMock(RouteExecutorFactoryInterface::class);

        $this->facade = new HttpFacadeLoggerDecorator(
            $decorated,
            $routeExecutorFactory,
        );
    }

    public function testGenerateUrlByRouteName()
    {
        $this->assertIsString($this->facade->generateUrlByRouteName('test'));
    }

    public function testExecute()
    {
        $this->assertInstanceOf(Response::class, $this->facade->execute($this->request));
    }

    public function testMatch()
    {
        $this->assertInstanceOf(RouteInterface::class, $this->facade->match($this->request));
    }

    public function testGetDeclaredRoutesNames()
    {
        $this->assertIsIterable($this->facade->getDeclaredRoutesNames());
    }

    public function testCreateRouteBuilder()
    {
        $this->assertInstanceOf(RouteBuilderInterface::class, $this->facade->createRouteBuilder());
    }
}
