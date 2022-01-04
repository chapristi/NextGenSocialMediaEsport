<?php


namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class VerifIfUserIsVerifiedSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security)
    {
    }
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['login_check', EventPriorities::POST_VALIDATE],
        ];
    }
    public function login_check(ViewEvent $event): void
    {
        $book = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($book instanceof Book && Request::METHOD_POST === $method) {

        }
    }
}