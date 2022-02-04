<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\AskUserJoinTeam;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final  class AddUserAskUserJoinTeamSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security){

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::VIEW => ['addUserAskUserJoinTeamSubscriber', EventPriorities::PRE_WRITE],
        ];
    }

    /**
     * @param ViewEvent $event
     */
    public function addUserAskUserJoinTeamSubscriber(ViewEvent $event)
    {
        $askedUser = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$askedUser instanceof AskUserJoinTeam || Request::METHOD_POST !== $method) {
            return;
        }
        $askedUser->setUsers($this->security->getUser());

    }
}