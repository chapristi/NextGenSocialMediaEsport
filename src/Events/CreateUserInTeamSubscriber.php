<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\TeamsEsport;
use App\Entity\UserJoinTeam;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;


final class CreateUserInTeamSubscriber implements EventSubscriberInterface
{

    public function __construct( private EntityManagerInterface $entityManager,private Security $security){

    }
    public static function getSubscribedEvents():array
    {


        return [
            KernelEvents::VIEW => ['createUserInTeams', EventPriorities::POST_WRITE],
        ];

    }
    public function  createUserInTeams(ViewEvent $event)
    {
        $team = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$team instanceof TeamsEsport  || Request::METHOD_POST !== $method) {
            return;
        }

            $userJoinTeam = (new UserJoinTeam())
                ->setRole(["ROLE_ADMIN"])
                ->addUser($this->security->getUser())
                ->addTeam($team)
                ->setIsValidated(1)

            ;
        $this -> entityManager -> persist($userJoinTeam);
        $this -> entityManager -> flush();

    }
}