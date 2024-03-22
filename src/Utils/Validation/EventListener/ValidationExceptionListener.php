<?php

namespace App\Utils\Validation\EventListener;


use App\Exception\ValidationException;
use App\Utils\Http\JsonErrorResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

#[AsEventListener(event: 'kernel.exception', priority: 11)]
class ValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ValidationException === false) return;

        $event->setResponse(new JsonErrorResponse(
            $exception->getErrors(),
            422
        ));
    }
}