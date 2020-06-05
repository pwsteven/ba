<?php

namespace App\Repository;

use App\Entity\Reimbursements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Reimbursements|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reimbursements|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reimbursements[]    findAll()
 * @method Reimbursements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReimbursementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reimbursements::class);
    }

    // /**
    //  * @return Reimbursements[] Returns an array of Reimbursements objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.User = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?Reimbursements
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.User = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function deleteBySomeField($value)
    {
        try {
            return $this->createQueryBuilder('r')
                ->delete()
                ->where('r.User = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            echo 'Error returning User: '.$e;
        }
    }

}
