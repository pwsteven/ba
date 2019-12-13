<?php

namespace App\Repository;

use App\Entity\FurtherCorrespondence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FurtherCorrespondence|null find($id, $lockMode = null, $lockVersion = null)
 * @method FurtherCorrespondence|null findOneBy(array $criteria, array $orderBy = null)
 * @method FurtherCorrespondence[]    findAll()
 * @method FurtherCorrespondence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FurtherCorrespondenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FurtherCorrespondence::class);
    }

    // /**
    //  * @return FurtherCorrespondence[] Returns an array of FurtherCorrespondence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySomeField($value): ?FurtherCorrespondence
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.User = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}
