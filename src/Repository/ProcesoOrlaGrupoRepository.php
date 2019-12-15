<?php

namespace App\Repository;

use App\Entity\ProcesoOrlaGrupo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProcesoOrlaGrupo|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProcesoOrlaGrupo|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProcesoOrlaGrupo[]    findAll()
 * @method ProcesoOrlaGrupo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProcesoOrlaGrupoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProcesoOrlaGrupo::class);
    }

    // /**
    //  * @return ProcesoOrlaGrupo[] Returns an array of ProcesoOrlaGrupo objects
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
    public function findOneBySomeField($value): ?ProcesoOrlaGrupo
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
