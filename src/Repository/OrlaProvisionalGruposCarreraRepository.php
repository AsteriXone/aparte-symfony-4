<?php

namespace App\Repository;

use App\Entity\OrlaProvisionalGruposCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method OrlaProvisionalGruposCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrlaProvisionalGruposCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method OrlaProvisionalGruposCarrera[]    findAll()
 * @method OrlaProvisionalGruposCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrlaProvisionalGruposCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrlaProvisionalGruposCarrera::class);
    }

    // /**
    //  * @return OrlaProvisionalGruposCarrera[] Returns an array of OrlaProvisionalGruposCarrera objects
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
    public function findOneBySomeField($value): ?OrlaProvisionalGruposCarrera
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
