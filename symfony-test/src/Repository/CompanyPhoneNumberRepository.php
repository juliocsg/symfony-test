<?php

namespace App\Repository;

use App\Entity\CompanyPhoneNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CompanyPhoneNumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompanyPhoneNumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompanyPhoneNumber[]    findAll()
 * @method CompanyPhoneNumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompanyPhoneNumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompanyPhoneNumber::class);
    }

    // /**
    //  * @return CompanyPhoneNumber[] Returns an array of CompanyPhoneNumber objects
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
    public function findOneBySomeField($value): ?CompanyPhoneNumber
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
