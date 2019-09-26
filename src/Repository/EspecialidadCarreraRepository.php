<?php

namespace App\Repository;

use App\Entity\EspecialidadCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EspecialidadCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method EspecialidadCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method EspecialidadCarrera[]    findAll()
 * @method EspecialidadCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EspecialidadCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EspecialidadCarrera::class);
    }

    // /**
    //  * @return EspecialidadCarrera[] Returns an array of EspecialidadCarrera objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EspecialidadCarrera
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
