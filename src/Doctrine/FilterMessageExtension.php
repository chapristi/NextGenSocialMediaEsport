<?php


namespace App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\ChatTeam;
use App\Entity\PrivateMessage;
use App\Entity\UserJoinTeam;
use App\Repository\UserJoinTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

final class FilterMessageExtension implements QueryCollectionExtensionInterface,QueryItemExtensionInterface
{
    public function __construct(private Security $security)
    {

    }

    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {

        $this->addWhere($queryBuilder, $resourceClass);
    }

    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, string $operationName = null, array $context = [])
    {

        $this->addWhere($queryBuilder, $resourceClass);
    }
    private function addWhere(QueryBuilder $queryBuilder, string $resourceClass): void
    {
        if (PrivateMessage::class !== $resourceClass   || $this->security->isGranted("ROLE_ADMIN")) {
           return;
       }
        $rootAlias = $queryBuilder->getRootAliases()[0];
        $queryBuilder->join("$rootAlias.bff", 'uu');
        //SELECT * FROM private_message INNER JOIN bff WHERE bff.sender_id = 155 OR bff.receiver_id = 155
        $queryBuilder->andWhere('uu.sender = :user OR uu.receiver = :user ');
        $queryBuilder ->setParameters([
            "user" => $this->security->getUser(),
        ]);









    }
}