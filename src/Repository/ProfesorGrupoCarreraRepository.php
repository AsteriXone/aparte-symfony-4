<?php

namespace App\Repository;

use App\Entity\ProfesorGrupoCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProfesorGrupoCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfesorGrupoCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfesorGrupoCarrera[]    findAll()
 * @method ProfesorGrupoCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesorGrupoCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfesorGrupoCarrera::class);
    }

    // /**
    //  * @return ProfesorGrupoCarrera[] Returns an array of ProfesorGrupoCarrera objects
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
    public function findOneBySomeField($value): ?ProfesorGrupoCarrera
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
