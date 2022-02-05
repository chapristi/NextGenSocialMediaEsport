<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;


use App\Entity\PrivateMessage;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final  class AddUserPrivateMessageSubscriber implements EventSubscriberInterface
{
    public function __construct(private Security $security){

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::VIEW => ['AddUserPrivateMessageSubscriber', EventPriorities::PRE_WRITE],
        ];
    }

    /**
     * @param ViewEvent $event
     */
    public function AddUserPrivateMessageSubscriber(ViewEvent $event)
    {
       $privateMessage = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$privateMessage instanceof PrivateMessage || Request::METHOD_POST !== $method) {
            return;
        }
        $privateMessage->setWriter($this->security->getUser());

    }
}