<?php

namespace App\Repository;

use App\Entity\UserCarrera;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserCarrera|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserCarrera|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserCarrera[]    findAll()
 * @method UserCarrera[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserCarreraRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserCarrera::class);
    }

    // /**
    //  * @return UserCarrera[] Returns an array of UserCarrera objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserCarrera
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
