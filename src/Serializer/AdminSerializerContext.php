<?php


namespace App\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class AdminSerializerContext
{
    public function __construct
    (
        private SerializerContextBuilderInterface $decorated,
        private AuthorizationCheckerInterface $authorizationChecker
    )
    {}
    public function Admin($resourceClass, $class,string $name,bool $normalization,Request $request){

        if ($resourceClass === $class::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() === "GET") {

            $context['groups'][] = "admin:Read:${name}";
        }
        if ($resourceClass === $class::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() !== "GET" ) {

            $context['groups'][] = "admin:Update:${name}";
        }
        if ($resourceClass === $class::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && false === $normalization) {
            $context['groups'][] = "admin:Write:${name}";
        }
        return $context;
    }

}