<?php

namespace App\Repository;

use App\Entity\VotacionesMuestraCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VotacionesMuestraCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method VotacionesMuestraCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method VotacionesMuestraCarrera[]    findAll()
 * @method VotacionesMuestraCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VotacionesMuestraCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VotacionesMuestraCarrera::class);
    }

    // /**
    //  * @return VotacionesMuestraCarrera[] Returns an array of VotacionesMuestraCarrera objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VotacionesMuestraCarrera
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
