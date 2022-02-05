<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;


use App\Entity\BFF;
use App\Entity\PrivateMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final  class AddUserBffSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security){

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::VIEW => ['AddUserBffSubscriber', EventPriorities::PRE_WRITE],
        ];
    }

    /**
     * @param ViewEvent $event
     */
    public function AddUserBffSubscriber(ViewEvent $event)
    {
        $bff = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$bff instanceof BFF || Request::METHOD_POST !== $method) {
            return;
        }
        $bff->setSender($this->security->getUser());

    }
}