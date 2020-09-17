<?php

namespace App\Repository;

use App\Entity\CitasFechaCuadranteGrupoCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CitasFechaCuadranteGrupoCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method CitasFechaCuadranteGrupoCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method CitasFechaCuadranteGrupoCarrera[]    findAll()
 * @method CitasFechaCuadranteGrupoCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CitasFechaCuadranteGrupoCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CitasFechaCuadranteGrupoCarrera::class);
    }

    // /**
    //  * @return CitasFechaCuadranteGrupoCarrera[] Returns an array of CitasFechaCuadranteGrupoCarrera objects
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
    public function findOneBySomeField($value): ?CitasFechaCuadranteGrupoCarrera
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
