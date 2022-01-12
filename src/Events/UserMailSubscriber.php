<?php
namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use App\Entity\VerifMail;
use App\Services\Mail\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Uid\Uuid as UuidAlias;
use Symfony\Component\Uid\UuidV4;


final class UserMailSubscriber implements EventSubscriberInterface
{

    public function __construct(private MailService $mailService, private EntityManagerInterface $entityManager)
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
        $token = Uuid::uuid4();

        $verifMail = (new VerifMail())
            ->setUser($user[0][0])
            ->setToken($token);
        $this -> entityManager -> persist($verifMail);
        $this -> entityManager -> flush();
        $this->mailService->sendMail(user_mail: "louis.0505@protonmail.com",subject: "Vous pouvez deshormez verifier votre compte",body: "MailTemplate/mailRegister.html.twig", params:[

                    "uuid" => $token

        ]);
    }
}