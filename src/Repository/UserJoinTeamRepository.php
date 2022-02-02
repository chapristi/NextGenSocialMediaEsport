<?php

namespace App\Repository;

use App\Entity\UserJoinTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserJoinTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserJoinTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserJoinTeam[]    findAll()
 * @method UserJoinTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserJoinTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserJoinTeam::class);
    }


    public function findByExampleField($user,$team)
    {

        return $this->createQueryBuilder('u')
            ->join('u.user', 'uu')
            ->join('u.team', 't')


            ->andWhere('uu = :user AND t = :team')
            ->setParameters([
                "user" => $user,
                "team" => $team,
            ])
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?UserJoinTeam
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
