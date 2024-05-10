<?php

namespace App\Repository;

use App\Entity\DiscountEarlyBooking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DiscountEarlyBookingRepository extends  ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountEarlyBooking::class);
    }
    public function getDiscountByDates(
        bool $nextYear,
        int $dayTravel,
        int $monthTravel,
        int $monthPayment

    ): ?DiscountEarlyBooking
    {
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.travel', 'travel');

        $qb
//            ->where('travel.nextYear = :nextYear')
            ->andWhere('travel.dayTravelStart <= :dayTravel AND travel.dayTravelEnd >= :dayTravel')
            ->andWhere('travel.monthTravelStart <= :monthTravel AND travel.monthTravelEnd >= :monthTravel')
//            ->setParameter('nextYear', $nextYear)
            ->setParameter('dayTravel', $dayTravel)
            ->setParameter('monthTravel', $monthTravel)
            ->andWhere('a.monthPaymentStart <= :monthPayment AND a.monthPaymentEnd >= :monthPayment')
            ->setParameter('monthPayment', $monthPayment)
            ->andWhere('a.nextYear = :nextYear')
            ->setParameter('nextYear', $nextYear)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
