<?php


namespace App\Serializer;


use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\TeamsEsport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class TeamsEsportContextBuilder implements SerializerContextBuilderInterface
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
     * give more possibilities to admin for TeamsEsport entity
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;

        if ($resourceClass === TeamsEsport::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() === "GET") {

            $context['groups'][] = 'admin:Read:TeamsEsport';
        }
        if ($resourceClass === TeamsEsport::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() !== "GET" ) {

            $context['groups'][] = 'admin:Update:TeamsEsport';
        }
        if ($resourceClass === TeamsEsport::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && false === $normalization) {
            $context['groups'][] = 'admin:Write:TeamsEsport';
        }
        return $context;
    }
}