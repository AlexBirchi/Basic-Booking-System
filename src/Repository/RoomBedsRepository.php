<?php

namespace App\Repository;

use App\Entity\RoomBeds;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoomBeds|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomBeds|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomBeds[]    findAll()
 * @method RoomBeds[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomBedsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomBeds::class);
    }

    // /**
    //  * @return RoomBeds[] Returns an array of RoomBeds objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoomBeds
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
