<?php

namespace App\Repository;

use App\Entity\VerifMail;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VerifMail|null find($id, $lockMode = null, $lockVersion = null)
 * @method VerifMail|null findOneBy(array $criteria, array $orderBy = null)
 * @method VerifMail[]    findAll()
 * @method VerifMail[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerifMailRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VerifMail::class);
    }

    // /**
    //  * @return VerifMail[] Returns an array of VerifMail objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VerifMail
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
