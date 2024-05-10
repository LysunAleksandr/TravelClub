<?php

namespace App\DataFixtures;

use App\Entity\DiscountChildren;
use App\Entity\DiscountEarlyBooking;
use App\Entity\TravelEarlyBooking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DiscountEarlyBookingFixtures extends Fixture
{
    private const LIST = [
        [
            'nextYear' => true,
            'dayTravelStart' => 1,
            'monthTravelStart' => 4,
            'dayTravelEnd' => 30,
            'monthTravelEnd' => 9,
            'discounts' => [
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 1,
                    'monthPaymentEnd' => 11,
                    'discount' => 7,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 12,
                    'monthPaymentEnd' => 12,
                    'discount' => 5,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => false,
                    'monthPaymentStart' => 01,
                    'monthPaymentEnd' => 01,
                    'discount' => 3,
                    'maxDiscount' => 1500,
                ]
            ]
        ],
        [
            'nextYear' => false,
            'dayTravelStart' => 1,
            'monthTravelStart' => 10,
            'dayTravelEnd' => 31,
            'monthTravelEnd' => 12,
            'discounts' => [
                [
                    'nextYear' => false,
                    'monthPaymentStart' => 1,
                    'monthPaymentEnd' => 3,
                    'discount' => 7,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => false,
                    'monthPaymentStart' => 4,
                    'monthPaymentEnd' => 4,
                    'discount' => 5,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => false,
                    'monthPaymentStart' => 5,
                    'monthPaymentEnd' => 5,
                    'discount' => 3,
                    'maxDiscount' => 1500,
                ]
            ]
        ],
        [
            'nextYear' => false,
            'dayTravelStart' => 1,
            'monthTravelStart' => 01,
            'dayTravelEnd' => 14,
            'monthTravelEnd' => 01,
            'discounts' => [
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 1,
                    'monthPaymentEnd' => 3,
                    'discount' => 7,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 4,
                    'monthPaymentEnd' => 4,
                    'discount' => 5,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => false,
                    'monthPaymentStart' => 5,
                    'monthPaymentEnd' => 5,
                    'discount' => 3,
                    'maxDiscount' => 1500,
                ]
            ]
        ],
        [
            'nextYear' => true,
            'dayTravelStart' => 15,
            'monthTravelStart' => 01,
            'dayTravelEnd' => 31,
            'monthTravelEnd' => 3,
            'discounts' => [
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 8,
                    'monthPaymentEnd' => 8,
                    'discount' => 7,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 9,
                    'monthPaymentEnd' => 9,
                    'discount' => 5,
                    'maxDiscount' => 1500,
                ],
                [
                    'nextYear' => true,
                    'monthPaymentStart' => 10,
                    'monthPaymentEnd' => 10,
                    'discount' => 3,
                    'maxDiscount' => 1500,
                ]
            ]
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        $repository = $manager->getRepository(TravelEarlyBooking::class);
        $repositoryDiscount = $manager->getRepository(DiscountEarlyBooking::class);
        foreach (self::LIST as $row) {
            $entity = $repository->findOneBy(
                [
                    'nextYear' => $row['nextYear'],
                    'dayTravelStart' => $row['dayTravelStart'],
                    'monthTravelStart' => $row['monthTravelStart'],
                    'dayTravelEnd' => $row['dayTravelEnd'],
                    'monthTravelEnd' => $row['monthTravelEnd'],
                ]
            );
            if (!$entity) {
                $entity = (new TravelEarlyBooking());
                $entity->setNextYear($row['nextYear']);
                $entity->setDayTravelStart($row['dayTravelStart']);
                $entity->setMonthTravelStart($row['monthTravelStart']);
                $entity->setDayTravelEnd($row['dayTravelEnd']);
                $entity->setMonthTravelEnd($row['monthTravelEnd']);
                $manager->persist($entity);

            }
            foreach ($row['discounts'] as $discount) {
                $discountEarlBooking = $repositoryDiscount->findOneBy(
                    [
                        'travel' => $entity,
                        'monthPaymentStart' => $discount['monthPaymentStart'],
                        'monthPaymentEnd' => $discount['monthPaymentEnd'],
                    ]
                );
                if (!$discountEarlBooking) {
                    $discountEarlBooking = (new DiscountEarlyBooking());
                    $discountEarlBooking->setTravel($entity);
                    $discountEarlBooking->setNextYear($discount['nextYear']);
                    $discountEarlBooking->setMonthPaymentStart($discount['monthPaymentStart']);
                    $discountEarlBooking->setMonthPaymentEnd($discount['monthPaymentEnd']);
                }
                $discountEarlBooking->setDiscount($discount['discount']);
                $discountEarlBooking->setMaxDiscount($discount['maxDiscount']);
                $manager->persist($discountEarlBooking);
            }
        }
        $manager->flush();
    }
}
