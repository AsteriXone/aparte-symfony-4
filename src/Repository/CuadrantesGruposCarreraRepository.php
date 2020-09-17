<?php

namespace App\Repository;

use App\Entity\CuadrantesGruposCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CuadrantesGruposCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method CuadrantesGruposCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method CuadrantesGruposCarrera[]    findAll()
 * @method CuadrantesGruposCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CuadrantesGruposCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CuadrantesGruposCarrera::class);
    }

    // /**
    //  * @return CuadrantesGruposCarrera[] Returns an array of CuadrantesGruposCarrera objects
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
    public function findOneBySomeField($value): ?CuadrantesGruposCarrera
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
