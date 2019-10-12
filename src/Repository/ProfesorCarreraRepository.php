<?php

namespace App\Repository;

use App\Entity\ProfesorCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProfesorCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfesorCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfesorCarrera[]    findAll()
 * @method ProfesorCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesorCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfesorCarrera::class);
    }

    // /**
    //  * @return ProfesorCarrera[] Returns an array of ProfesorCarrera objects
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
    public function findOneBySomeField($value): ?ProfesorCarrera
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
