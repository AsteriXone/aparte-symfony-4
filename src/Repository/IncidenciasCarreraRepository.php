<?php

namespace App\Repository;

use App\Entity\IncidenciasCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method IncidenciasCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method IncidenciasCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method IncidenciasCarrera[]    findAll()
 * @method IncidenciasCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidenciasCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IncidenciasCarrera::class);
    }

    // /**
    //  * @return IncidenciasCarrera[] Returns an array of IncidenciasCarrera objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?IncidenciasCarrera
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
