<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Business\Executor;

use Micro\Plugin\Http\Business\Executor\HttpExecutorLoggerAwareDecorator;
use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterInterface;
use Micro\Plugin\Http\Exception\HttpException;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpExecutorLoggerAwareDecoratorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExecute(bool $isFlush, bool $exceptException)
    {
        $decorator = new HttpExecutorLoggerAwareDecorator(
            $this->createDecorated($exceptException),
            $this->createLogger(),
            $this->createLogger(),
            $this->createFormatter(),
            $this->createFormatter()
        );

        if ($exceptException) {
            $this->expectException(HttpException::class);
            $this->expectExceptionCode(404);
        }

        $this->assertInstanceOf(
            Response::class,
            $decorator->execute(
                $this->createMock(Request::class),
                $isFlush
            )
        );
    }

    public function dataProvider()
    {
        return [
            [
                true, true,
            ],
            [
                false, true,
            ],
            [
                true, false,
            ],
            [
                false, false,
            ],
        ];
    }

    protected function createDecorated(bool $throwException)
    {
        $decorated = $this->createMock(HttpFacadeInterface::class);
        $methodMock = $decorated
            ->expects($this->once())
            ->method('execute')
        ;
        if ($throwException) {
            $methodMock->willThrowException(new HttpException('test', 404));
        } else {
            $methodMock->willReturn(
                $this->createMock(Response::class)
            );
        }

        return $decorated;
    }

    protected function createLogger()
    {
        return $this->createMock(LoggerInterface::class);
    }

    protected function createFormatter()
    {
        return $this->createMock(LogFormatterInterface::class);
    }
}
