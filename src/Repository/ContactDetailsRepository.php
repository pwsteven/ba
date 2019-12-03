<?php

namespace App\Repository;

use App\Entity\ContactDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method ContactDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactDetails[]    findAll()
 * @method ContactDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactDetails::class);
    }

    // /**
    //  * @return ContactDetails[] Returns an array of ContactDetails objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function findOneBySomeField($value): ?ContactDetails
    {
        try {
            return $this->createQueryBuilder('c')
                ->andWhere('c.User = :val')
                ->setParameter('val', $value)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            echo 'Error returning User: '.$e;
        }
    }

}
