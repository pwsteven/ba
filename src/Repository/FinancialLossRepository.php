<?php

namespace App\Repository;

use App\Entity\FinancialLoss;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FinancialLoss|null find($id, $lockMode = null, $lockVersion = null)
 * @method FinancialLoss|null findOneBy(array $criteria, array $orderBy = null)
 * @method FinancialLoss[]    findAll()
 * @method FinancialLoss[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FinancialLossRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FinancialLoss::class);
    }

    // /**
    //  * @return FinancialLoss[] Returns an array of FinancialLoss objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.User = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?FinancialLoss
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.User = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
