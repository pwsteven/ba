<?php

namespace App\Repository;

use App\Entity\PersonalDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method PersonalDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonalDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonalDetails[]    findAll()
 * @method PersonalDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonalDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonalDetails::class);
    }

    // /**
    //  * @return PersonalDetails[] Returns an array of PersonalDetails objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.User = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }



    public function findOneBySomeField($value): ?PersonalDetails
    {
        try {
            return $this->createQueryBuilder('p')
                ->andWhere('p.User = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            echo 'Error returning User: '.$e;
        }
    }


}
