<?php

namespace App\Repository;

use App\Entity\ProductosCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductosCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductosCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductosCarrera[]    findAll()
 * @method ProductosCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductosCarrera::class);
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
