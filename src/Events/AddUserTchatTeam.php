<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;

use App\Entity\ChatTeam;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

/**
 * This class will add a user to ChatTeam to avoid some errors
 * @author  Chapristi <louis.0505@protonmail.com>
 *
 */
final class AddUserTchatTeam implements EventSubscriberInterface
{


    public function __construct( private EntityManagerInterface $entityManager,private Security $security){

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::VIEW => ['addUserInUserJoinTeam', EventPriorities::POST_WRITE],
        ];
    }
    public function  addUserInUserJoinTeam(ViewEvent $event)
    {
        $joinTeam = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$joinTeam instanceof ChatTeam || Request::METHOD_POST !== $method) {
            return;
        }
        $joinTeam->setUser($this->security->getUser());

    }


}