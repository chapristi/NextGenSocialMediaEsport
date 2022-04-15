<?php
// api/src/Serializer/BookContextBuilder.php

namespace App\Serializer;

use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\UserJoinTeam;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use App\Entity\User;

final class UserJoinTeamContextBuilder implements SerializerContextBuilderInterface
{


    public function __construct
    (
        private SerializerContextBuilderInterface $decorated,
        private AuthorizationCheckerInterface $authorizationChecker
    )
    {}

    /**
     * @param Request $request
     * @param bool $normalization
     * @param array|null $extractedAttributes
     * @return array
     * give more possibilities to admin for UserJoinTeam entity
     */
    public function createFromRequest(Request $request, bool $normalization, ?array $extractedAttributes = null): array
    {

        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;

        if ($resourceClass === UserJoinTeam::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() === "GET") {

            $context['groups'][] = 'admin:Read:UserJoinTeam';
        }
        if ($resourceClass === UserJoinTeam::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() !== "GET" ) {

            $context['groups'][] = 'admin:Update:UserJoinTeam';
        }
        if ($resourceClass === UserJoinTeam::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && false === $normalization) {
            $context['groups'][] = 'admin:Write:UserJoinTeam';
        }

        return $context;
    }
}