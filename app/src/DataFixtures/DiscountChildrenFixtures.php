<?php

namespace App\DataFixtures;

use App\Entity\DiscountChildren;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscountChildrenFixtures extends Fixture
{
    private const LIST = [
        [
            'age' => 6,
            'discount' => 80,
            'maxDiscount' => null,
        ],
        [
            'age' => 12,
            'discount' => 30,
            'maxDiscount' => 4500,
        ],
        [
            'age' => 18,
            'discount' => 10,
            'maxDiscount' => null,
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        $repository = $manager->getRepository(DiscountChildren::class);
        foreach (self::LIST as $row) {
            $entity = $repository->findOneByAge($row['age']);
            if (!$entity) {
                $entity = (new DiscountChildren());
                $entity->setAge($row['age']);
                $manager->persist($entity);
            }
            $entity->setDiscount($row['discount']);
            $entity->setMaxDiscount($row['maxDiscount']);
        }
        $manager->flush();
    }
}
