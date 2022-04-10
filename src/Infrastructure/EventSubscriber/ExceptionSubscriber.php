<?php

namespace App\Infrastructure\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private FlashBagInterface $flashBag;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /** @return array<string, array<string, int>> */
    public static function getSubscribedEvents(): array
    {
        return ['kernel.exception' => ['onKernelException', 255]];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $patternMatch = '/^\/(_(profiler|wdt)|css|images|js|assets)/';
        $request = $event->getRequest();
        if (preg_match($patternMatch, $request->getPathInfo()) || !$this->verifyAsJson($request)) {
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

    private function formatAndReturnJson(\Throwable $exception): JsonResponse
    {
        $headers = [];
        $genericError = match ($exception::class) {
            HttpExceptionInterface::class => $this->formatterHttpExceptionInterface($exception, $headers),
            AuthenticationException::class => $this->formatterAuthenticationException($exception),
            default => [
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'error' => $exception->getMessage(),
                'type' => $exception::class,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ],
        };
        return new JsonResponse($genericError, $genericError['status'], $headers);
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
