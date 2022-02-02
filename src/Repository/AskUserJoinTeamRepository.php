<?php

namespace App\Repository;

use App\Entity\AskUserJoinTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AskUserJoinTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method AskUserJoinTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method AskUserJoinTeam[]    findAll()
 * @method AskUserJoinTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AskUserJoinTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AskUserJoinTeam::class);
    }

    // /**
    //  * @return AskUserJoinTeam[] Returns an array of AskUserJoinTeam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AskUserJoinTeam
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
