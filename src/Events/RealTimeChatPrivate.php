<?php


namespace App\Events;


use ApiPlatform\Core\EventListener\EventPriorities;


use App\Entity\ChatTeam;
use App\Entity\PrivateMessage;
use Pusher\Pusher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

final  class RealTimeChatPrivate implements EventSubscriberInterface
{
    public function __construct(private Security $security){

    }
    /**
     * @return array
     */
    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::VIEW => ['RealTimeChatPrivate', EventPriorities::POST_WRITE],
        ];
    }

    /**
     * @param ViewEvent $event
     */
    public function RealTimeChatPrivate(ViewEvent $event)
    {
        $privateChat = $event->getControllerResult();

        $method = $event->getRequest()->getMethod();
        if (!$privateChat instanceof PrivateMessage) {
            return;
        }
        switch ($method) {
            case Request::METHOD_POST:
                $this->RequestToRealTimeChat($privateChat->getMessage(), $privateChat->getWriter()->getCode(), $privateChat->getCreatedAt(), "POST", $privateChat->getBff()->getToken(), $privateChat->getToken());
                break;
            case Request::METHOD_PATCH || Request::METHOD_PUT:
                $this->RequestToRealTimeChat($privateChat->getMessage(), $privateChat->getWriter()->getCode(), $privateChat->getCreatedAt(), "EDIT",  $privateChat->getBff()->getToken(), $privateChat->getToken());
                break;
            case Request::METHOD_DELETE:
                $this->RequestToRealTimeChat("","","","DELETE",$privateChat->getBff()->getToken(),$privateChat->getToken());
                break;
        }
    }
    private function RequestToRealTimeChat(string $message = null, string $user = null, string $createdAt = null, string $satus, string $BFFToken = null, int $id)
    {
        $options = array(
            'cluster' => 'eu',
            'useTLS' => true
        );
        $pusher = new Pusher(
            '357acb03897880c77f63',
            '9784c00ccd6c613f81a9',
            '1343207',
            $options
        );

        if ($satus === "POST" || $satus === "EDIT") {
            $data['message'] = $message;
            $data["sender"] = $user;
            $data["createdAt"] = $createdAt;
            $data["status"] = $satus;
            $data["idChat"] = $id;
        } elseif ($satus === "DELETE") {
            $data["status"] = $satus;
            $data["idChat"] = $id;
        }


        $pusher->trigger("channel-chatteam-$BFFToken", 'my-event', $data);
    }


}