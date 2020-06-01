<?php

namespace App\Repository;

use App\Entity\FileReference;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FileReference|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileReference|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileReference[]    findAll()
 * @method FileReference[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileReferenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileReference::class);
    }

    // /**
    //  * @return FileReference[] Returns an array of FileReference objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByExampleFields($value, $value2)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :val')
            ->andWhere('f.FileStage = :val2')
            ->setParameters([
                'val' => $value,
                'val2' => $value2,
            ])
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByFilteredExampleFields($value, $value2)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.user = :val')
            ->andWhere('f.FormUploadName = :val2')
            ->setParameters([
                'val' => $value,
                'val2' => $value2,
            ])
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }


    /*
    public function findOneBySomeField($value): ?FileReference
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
