<?php

namespace App\Repository;

use App\Entity\ProductosCarreraGrupoCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductosCarreraGrupoCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductosCarreraGrupoCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductosCarreraGrupoCarrera[]    findAll()
 * @method ProductosCarreraGrupoCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosCarreraGrupoCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductosCarreraGrupoCarrera::class);
    }

    // /**
    //  * @return MuestrasCarreraGrupoCarrera[] Returns an array of MuestrasCarreraGrupoCarrera objects
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
    public function findOneBySomeField($value): ?MuestrasCarreraGrupoCarrera
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
