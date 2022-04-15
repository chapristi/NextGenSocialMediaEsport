<?php


namespace App\Serializer;


use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\BFF;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class  BffContextBuilder implements SerializerContextBuilderInterface
{

    public function __construct
    (
        private SerializerContextBuilderInterface $decorated,
        private AuthorizationCheckerInterface $authorizationChecker
    )
    {}

    /**
     *
     * @param Request $request
     * @param bool $normalization
     * @param array|null $extractedAttributes
     * @return array
     * give mor possibilities for admins to BFF entity
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request, $normalization, $extractedAttributes);
        $resourceClass = $context['resource_class'] ?? null;
        if ($resourceClass === BFF::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() === "GET") {

            $context['groups'][] = 'admin:Read:BFF';
        }
        if ($resourceClass ===  BFF::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && true === $normalization && $request->getMethod() !== "GET" ) {

            $context['groups'][] = 'admin:Update:BFF';
        }
        if ($resourceClass === BFF::class && isset($context['groups']) && $this->authorizationChecker->isGranted('ROLE_ADMIN') && false === $normalization) {
            $context['groups'][] = 'admin:Write:BFF';
        }
        return $context;

    }
}