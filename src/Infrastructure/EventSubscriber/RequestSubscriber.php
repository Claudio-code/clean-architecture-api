<?php

namespace App\Infrastructure\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RequestSubscriber implements EventSubscriberInterface
{
    public function onRequestEvent(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $request->request->add($this->moveFilesToAll($request));
        if ($event->isMainRequest() === false || $request->getContentType() !== 'json') {
            return;
        }
        $request->request->add($this->decodeJsonContent($request));
    }

    private function decodeJsonContent(Request $request): array
    {
        $jsonDecoded = json_decode($request->getContent(), true);
        return match (json_last_error() !== JSON_ERROR_NONE) {
            true => throw new BadRequestHttpException('Falha ao interpretar JSON: ' . json_last_error_msg()),
            default => $jsonDecoded,
        };
    }

    private function moveFilesToAll(Request $request): array
    {
        return $request->files->all();
    }

    public static function getSubscribedEvents(): array
    {
        return [RequestEvent::class => 'onRequestEvent'];
    }
}
