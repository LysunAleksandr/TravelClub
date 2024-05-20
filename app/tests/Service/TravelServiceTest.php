<?php

namespace App\Tests;

use App\Entity\Travel;
use App\Repository\DiscountChildrenRepository;
use App\Repository\DiscountEarlyBookingRepository;
use App\Service\TravelService;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;;

class TravelServiceTest extends KernelTestCase
{
    private TravelService $service;

    /**
     * @throws Exception
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();
        if (!self::$booted) {
            self::bootKernel();
        }


        $this->service = new TravelService(
            discountChildrenRepository: self::getContainer()->get(DiscountChildrenRepository::class),
            discountEarlyBookingRepository: self::getContainer()->get(DiscountEarlyBookingRepository::class)
        );
    }

    public function provideData(): iterable
    {
        yield 'discount7' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-11-25', 'result' => 93];
        yield 'discount5' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-12-25', 'result' => 95];
        yield 'discount3' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2027-01-25', 'result' => 97];
        yield 'children12' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2008-05-11', 'datePayment' => '2023-11-25', 'result' => 90];
        yield 'children6' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2013-05-11', 'datePayment' => '2023-11-25', 'result' => 70];
        yield 'children3' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2019-05-11', 'datePayment' => '2023-11-25', 'result' => 20];
        yield 'max1500' => ['basicCost' => 100000, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-11-25', 'result' => 98500];
    }

    /**
     * @dataProvider provideData
     */
    public function testCreateAndCheck($basicCost, $dateStart, $dateBirth, $datePayment, $resultSum): void
    {
            $travel = new Travel();
            $travel->setBasicCost($basicCost);
            $travel->setDateBirth( \date_create($dateBirth));
            $travel->setDatePayment(\date_create($datePayment));
            $travel->setDateStart(\date_create($dateStart));

            $result = $this->service->calculate($travel);

            self::assertNotNull($result);
            self::assertInstanceOf(Travel::class, $result);
            self::assertEquals($resultSum, $result->getFullCost());
    }
}
