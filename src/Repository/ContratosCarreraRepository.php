<?php

namespace App\Repository;

use App\Entity\ContratosCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ContratosCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContratosCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContratosCarrera[]    findAll()
 * @method ContratosCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContratosCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContratosCarrera::class);
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
