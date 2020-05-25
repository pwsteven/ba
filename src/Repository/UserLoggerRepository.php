<?php

namespace App\Repository;

use App\Entity\UserLogger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserLogger|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserLogger|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserLogger[]    findAll()
 * @method UserLogger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserLoggerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserLogger::class);
    }

    // /**
    //  * @return UserLogger[] Returns an array of UserLogger objects
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
    public function findOneBySomeField($value): ?UserLogger
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
