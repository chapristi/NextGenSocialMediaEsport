<?php

namespace App\Repository;

use App\Entity\ChatTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ChatTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChatTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChatTeam[]    findAll()
 * @method ChatTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatTeam::class);
    }

    // /**
    //  * @return ChatTeam[] Returns an array of ChatTeam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ChatTeam
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
