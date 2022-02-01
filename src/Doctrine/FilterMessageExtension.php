<?php


namespace App\Doctrine;


use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\ChatTeam;
use App\Entity\UserJoinTeam;
use App\Repository\UserJoinTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Security;

class FilterMessageExtension implements QueryCollectionExtensionInterface,QueryItemExtensionInterface
{
    public function __construct(private Security $security,private EntityManagerInterface $entityManager)
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
        //if (ChatTeam::class !== $resourceClass   || $this->security->isGranted("ROLE_ADMIN")) {
          // return;
       // }



        //$query = $this->entityManager->createQuery('SELECT * FROM chat_team INNER JOIN user_join_team ON chat_teams.user_id = user_join_team.user_id ');
        //$queryBuilder->andWhere("$rootAlias.user = :current_user OR $rootAlias.team. = :test");
        //$queryBuilder->setParameter('current_user', $this->security->getUser()->getId());

        //dd($query);
        return;




    }
}