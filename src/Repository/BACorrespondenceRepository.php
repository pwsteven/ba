<?php

namespace App\Repository;

use App\Entity\BACorrespondence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method BACorrespondence|null find($id, $lockMode = null, $lockVersion = null)
 * @method BACorrespondence|null findOneBy(array $criteria, array $orderBy = null)
 * @method BACorrespondence[]    findAll()
 * @method BACorrespondence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BACorrespondenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BACorrespondence::class);
    }

    // /**
    //  * @return BACorrespondence[] Returns an array of BACorrespondence objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.userID = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?BACorrespondence
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.userID = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
