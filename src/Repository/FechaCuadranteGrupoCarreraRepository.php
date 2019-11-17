<?php

namespace App\Repository;

use App\Entity\FechaCuadranteGrupoCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FechaCuadranteGrupoCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method FechaCuadranteGrupoCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method FechaCuadranteGrupoCarrera[]    findAll()
 * @method FechaCuadranteGrupoCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FechaCuadranteGrupoCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FechaCuadranteGrupoCarrera::class);
    }

    // /**
    //  * @return FechaCuadranteGrupoCarrera[] Returns an array of FechaCuadranteGrupoCarrera objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FechaCuadranteGrupoCarrera
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
