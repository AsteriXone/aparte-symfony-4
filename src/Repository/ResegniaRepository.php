<?php

namespace App\Repository;

use App\Entity\Resegnia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Resegnia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Resegnia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Resegnia[]    findAll()
 * @method Resegnia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResegniaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Resegnia::class);
    }

    // /**
    //  * @return Resegnia[] Returns an array of Resegnia objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Resegnia
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
