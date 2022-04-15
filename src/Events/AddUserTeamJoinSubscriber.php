<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;

use App\Entity\UserJoinTeam;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

/**
 * This class will add a user to UserJoinTeam to avoid some errors
 * @author  Chapristi <louis.0505@protonmail.com>
 *
 */
final class AddUserTeamJoinSubscriber implements EventSubscriberInterface
{


    public function __construct(private Security $security){

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::VIEW => ['addUserInUserJoinTeam', EventPriorities::PRE_VALIDATE],
        ];
    }
    public function  addUserInUserJoinTeam(ViewEvent $event)
    {
        $joinTeam = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$joinTeam instanceof UserJoinTeam || Request::METHOD_POST !== $method) {
            return;
        }
        $joinTeam->addUser($this->security->getUser());

    }


}