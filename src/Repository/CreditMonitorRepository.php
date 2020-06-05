<?php

namespace App\Repository;

use App\Entity\CreditMonitor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method CreditMonitor|null find($id, $lockMode = null, $lockVersion = null)
 * @method CreditMonitor|null findOneBy(array $criteria, array $orderBy = null)
 * @method CreditMonitor[]    findAll()
 * @method CreditMonitor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreditMonitorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CreditMonitor::class);
    }

    // /**
    //  * @return CreditMonitor[] Returns an array of CreditMonitor objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.User = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findOneBySomeField($value): ?CreditMonitor
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.User = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function deleteBySomeField($value)
    {
        try {
            return $this->createQueryBuilder('c')
                ->delete()
                ->where('c.User = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            echo 'Error returning User: '.$e;
        }
    }

}
