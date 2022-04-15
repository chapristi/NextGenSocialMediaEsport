<?php

namespace App\Repository;

use App\Entity\CatgeoriesTeamsEsport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatgeoriesTeamsEsport|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatgeoriesTeamsEsport|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatgeoriesTeamsEsport[]    findAll()
 * @method CatgeoriesTeamsEsport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatgeoriesTeamsEsportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatgeoriesTeamsEsport::class);
    }

    // /**
    //  * @return CatgeoriesTeamsEsport[] Returns an array of CatgeoriesTeamsEsport objects
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
    public function findOneBySomeField($value): ?CatgeoriesTeamsEsport
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
