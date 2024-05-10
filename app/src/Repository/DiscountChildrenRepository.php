<?php

namespace App\Repository;

use App\Entity\DiscountChildren;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DiscountChildrenRepository extends  ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiscountChildren::class);
    }
    public function getDiscountChildrenByClientAge(int $age): ?DiscountChildren
    {
        $qb = $this
            ->createQueryBuilder('a');

        $qb
            ->where('a.age > :age')
            ->setParameter('age', $age)
            ->orderBy('a.age', 'ASC')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
