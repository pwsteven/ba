<?php

namespace App\Repository;

use App\Entity\EmotionalDistress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method EmotionalDistress|null find($id, $lockMode = null, $lockVersion = null)
 * @method EmotionalDistress|null findOneBy(array $criteria, array $orderBy = null)
 * @method EmotionalDistress[]    findAll()
 * @method EmotionalDistress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmotionalDistressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EmotionalDistress::class);
    }

    // /**
    //  * @return EmotionalDistress[] Returns an array of EmotionalDistress objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.User = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    public function findOneBySomeField($value): ?EmotionalDistress
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.User = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function deleteBySomeField($value)
    {
        try {
            return $this->createQueryBuilder('e')
                ->delete()
                ->where('e.User = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            echo 'Error returning User: '.$e;
        }
    }

}
