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

use Micro\Plugin\Http\Business\Logger\Formatter\LogFormatterInterface;
use Micro\Plugin\Http\Exception\HttpException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
abstract class AbstractFormatTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testFormat(bool $hasResponse, \Throwable|null $throwable)
    {
        $object = $this->createTestObject();

        $this->assertIsString(
            $object->format(
                $this->createRequest(),
                $this->createResponse($hasResponse),
                $this->createThrowable($throwable)
            )
        );
    }

    public function dataProvider()
    {
        return [
            [false, null],
            [true, null],
            [true, new HttpException()],
            [false, new HttpException()],
            [true, new \Exception()],
            [false, new \Exception()],
        ];
    }

    public function createThrowable(\Throwable|null $throwable): \Throwable|null
    {
        return $throwable;
    }

    protected function createResponse(bool $hasResponse): Response|null
    {
        if (!$hasResponse) {
            return null;
        }

        return $this->createMock(Response::class);
    }

    protected function createRequest(): Request
    {
        return Request::create('/test');
    }

    abstract protected function getTestClass(): string;

    protected function createTestObject(): LogFormatterInterface
    {
        $testClass = $this->getTestClass();

        return new $testClass($this->getFormattedVariable());
    }

    protected function getFormattedVariable()
    {
        return '{{'.$this->getVariable().'}}';
    }

    abstract public function getVariable(): string;
}
