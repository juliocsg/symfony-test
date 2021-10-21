<?php

namespace App\Repository;

use App\Entity\PersonPhoneNumber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PersonPhoneNumber|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonPhoneNumber|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonPhoneNumber[]    findAll()
 * @method PersonPhoneNumber[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonPhoneNumberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonPhoneNumber::class);
    }

    // /**
    //  * @return PersonPhoneNumber[] Returns an array of PersonPhoneNumber objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PersonPhoneNumber
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
