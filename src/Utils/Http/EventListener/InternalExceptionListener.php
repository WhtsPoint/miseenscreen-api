<?php

namespace App\Utils\Http\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;

#[AsEventListener(event: 'kernel.exception', priority: 10)]
class InternalExceptionListener
{
    public function __construct(
        private string $kernelEnv,
        private LoggerInterface $logger
    ) {}

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpException === false && $this->kernelEnv === 'prod') {
            $this->logger->error($exception);
            $event->setThrowable(new HttpException(500, 'Internal server error'));
        }
    }
}