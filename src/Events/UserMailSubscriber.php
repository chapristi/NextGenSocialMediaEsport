<?php
namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Services\Mail\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;


final class UserMailSubscriber implements EventSubscriberInterface
{
    public function __construct(private MailService $mailService )
    {

    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['sendMail', EventPriorities::POST_WRITE],
        ];
    }

    public function sendMail(ViewEvent $event): void
    {
        $user = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();

        if (!$user[0][0] instanceof User || Request::METHOD_POST !== $method) {
            return;
        }

        $this->mailService->sendMail(user_mail: "louis.0505@protonmail.com",subject: "Vous pouvez deshormez verifier votre compte",body: "MailTemplate/mailRegister.html.twig", params:[

                    "uuid" => "sdkfh"

        ]);
    }
}