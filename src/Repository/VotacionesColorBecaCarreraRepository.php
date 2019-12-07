<?php

namespace App\Repository;

use App\Entity\VotacionesColorBecaCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method VotacionesColorBecaCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method VotacionesColorBecaCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method VotacionesColorBecaCarrera[]    findAll()
 * @method VotacionesColorBecaCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VotacionesColorBecaCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VotacionesColorBecaCarrera::class);
    }

    // /**
    //  * @return VotacionesColorBecaCarrera[] Returns an array of VotacionesColorBecaCarrera objects
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
    public function findOneBySomeField($value): ?VotacionesColorBecaCarrera
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
