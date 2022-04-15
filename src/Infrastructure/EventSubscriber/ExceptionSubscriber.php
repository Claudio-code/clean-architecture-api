<?php

namespace App\Infrastructure\EventSubscriber;

use App\Domain\Exception\DomainException;
use App\Infrastructure\Persistence\Exception\ClientAlreadyExistsInTheDatabaseException;
use App\Infrastructure\Persistence\Exception\PersistenceException;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Throwable;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private const PATTERN_MATCH = '/^\/(_(profiler|wdt)|css|images|js|assets)/';

    /** @return array<string, array<string, int>> */
    public static function getSubscribedEvents(): array
    {
        return ['kernel.exception' => ['onKernelException', 255]];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        if (preg_match(self::PATTERN_MATCH, $request->getPathInfo()) || !$this->verifyAsJson($request)) {
            return;
        }
        $throwableResponse = $this->formatAndReturnJson($event->getThrowable());
        $event->setResponse($throwableResponse);
    }

    private function verifyAsJson(Request $request): bool
    {
        return (
            str_contains($request->headers->get('accept', ''), 'application/json') ||
            $request->getRequestFormat() == 'json' ||
            str_starts_with($request->getRequestUri(), '/api/doc')
        );
    }

    private function formatAndReturnJson(Throwable $exception): JsonResponse
    {
        $headers = [];
        $genericError = match (get_class($exception)) {
            HttpExceptionInterface::class => $this->formatterHttpExceptionInterface($exception, $headers),
            AuthenticationException::class => $this->formatterAuthenticationException($exception),
            DomainException::class, PersistenceException::class,
            ClientAlreadyExistsInTheDatabaseException::class => $this->formatterCustomException($exception),
            default => $this->formatterDefaultException($exception),
        };
        return new JsonResponse($genericError, $genericError['status'], $headers);
    }

    private function formatterCustomException(Exception $exception): array
    {
        return [
            'status' => $exception->getCode(),
            'error' => $exception->getMessage(),
            'type' => $exception::class,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];
    }

    private function formatterDefaultException(Throwable $exception): array
    {
        return [
            'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
            'error' => $exception->getMessage(),
            'type' => $exception::class,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];
    }

    private function formatterHttpExceptionInterface(HttpExceptionInterface $exception, array &$headers): array
    {
        $headers = $exception->getHeaders();
        return [
            'status' => $exception->getStatusCode(),
            'error' => $exception->getMessage(),
            'type' => $exception::class,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];
    }

    private function formatterAuthenticationException(AuthenticationException $exception): array
    {
        return [
            'status' => JsonResponse::HTTP_UNAUTHORIZED,
            'error' => strtr($exception->getMessageKey(), $exception->getMessageData()),
            'type' => $exception::class,
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ];
    }
}
