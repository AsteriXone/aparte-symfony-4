<?php

namespace App\Repository;

use App\Entity\ColorBecasCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ColorBecasCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ColorBecasCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ColorBecasCarrera[]    findAll()
 * @method ColorBecasCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ColorBecasCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ColorBecasCarrera::class);
    }

    // /**
    //  * @return Muestras[] Returns an array of Muestras objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Muestras
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
