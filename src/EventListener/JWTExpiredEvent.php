<?php


namespace App\EventListener;


class JWTExpiredEvent
{
    public function onJWTExpired(\Lexik\Bundle\JWTAuthenticationBundle\Event\JWTExpiredEvent $event)
    {

        $response = $event->getResponse()->setMessage('Your token is expired, please renew it.');

    }


}