<?php

namespace App\Repository;

use App\Entity\CatgeoriesUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatgeoriesUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatgeoriesUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatgeoriesUser[]    findAll()
 * @method CatgeoriesUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatgeoriesUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatgeoriesUser::class);
    }

    // /**
    //  * @return CatgeoriesUser[] Returns an array of CatgeoriesUser objects
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
    public function findOneBySomeField($value): ?CatgeoriesUser
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
