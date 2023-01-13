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

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Plugin\Http\Business\Formatter\LogFormatterInterface;
use Micro\Plugin\Http\Exception\HttpException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpExecutorLoggerAwareDecorator implements RouteExecutorInterface
{
    public function __construct(
        private RouteExecutorInterface $decorated,
        private LoggerInterface $loggerAccess,
        private LoggerInterface $loggerError,
        private LogFormatterInterface $logAccessFormatter,
        private LogFormatterInterface $logErrorFormatter
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request, bool $flush = true): Response
    {
        $response = null;
        $exception = null;
        try {
            $response = $this->decorated->execute($request, $flush);
        } catch (HttpException $httpException) {
            $exception = $httpException;
        } catch (\Throwable $throwable) {
            $exception = $throwable;
        } finally {
            $this->loggerAccess->info(
                $this->logAccessFormatter->format($request, $response, $exception)
            );

            if ($exception) {
                $this->loggerError->critical(
                    $this->logErrorFormatter->format($request, $response, $exception)
                );

                throw $exception;
            }

            return $response;
        }
    }
}
