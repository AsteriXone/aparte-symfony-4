<?php

namespace App\Repository;

use App\Entity\Cuadrantes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cuadrantes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cuadrantes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cuadrantes[]    findAll()
 * @method Cuadrantes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuadrantesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cuadrantes::class);
    }

    // /**
    //  * @return Cuadrantes[] Returns an array of Cuadrantes objects
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
    public function findOneBySomeField($value): ?Cuadrantes
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
