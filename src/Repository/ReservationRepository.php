<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function checkRoomAvailability(Room $room, \DateTime $checkIn, \DateTime $checkOut): bool
    {
        $reservation = $this->createQueryBuilder('r')
            ->andWhere('r.room = :roomId')
            ->andWhere('r.state IN (:states)')
            ->andWhere(':checkIn BETWEEN r.checkIn AND r.checkOut OR :checkOut BETWEEN r.checkIn AND r.checkOut')
            ->setParameter('roomId', $room->getId())
            ->setParameter('states', [Reservation::STATUS_INITIAL, Reservation::STATUS_ACTIVE])
            ->setParameter('checkIn', $checkIn)
            ->setParameter('checkOut', $checkOut)
            ->getQuery()
            ->getOneOrNullResult();

        return !$reservation;
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
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
    public function findOneBySomeField($value): ?Reservation
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
