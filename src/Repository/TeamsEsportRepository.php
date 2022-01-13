<?php

namespace App\Repository;

use App\Entity\TeamsEsport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamsEsport|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamsEsport|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamsEsport[]    findAll()
 * @method TeamsEsport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamsEsportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamsEsport::class);
    }

    // /**
    //  * @return TeamsEsport[] Returns an array of TeamsEsport objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TeamsEsport
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
