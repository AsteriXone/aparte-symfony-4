<?php

namespace App\Repository;

use App\Entity\OrlasProvisionalGrupoCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrlasProvisionalGrupoCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrlasProvisionalGrupoCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrlasProvisionalGrupoCarrera[]    findAll()
 * @method OrlasProvisionalGrupoCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrlasProvisionalGrupoCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrlasProvisionalGrupoCarrera::class);
    }

    // /**
    //  * @return OrlasProvisionalGrupoCarrera[] Returns an array of OrlasProvisionalGrupoCarrera objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrlasProvisionalGrupoCarrera
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
