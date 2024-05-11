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
        yield 'fix93' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-11-25', 'result' => 93];
        yield 'fix95' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-12-25', 'result' => 95];
        yield 'fix97' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2000-05-11', 'datePayment' => '2027-01-25', 'result' => 97];
        yield 'fix93' => ['basicCost' => 100, 'dateStart' => '2027-01-15', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-08-25', 'result' => 93];
        yield 'fix95' => ['basicCost' => 100, 'dateStart' => '2027-01-15', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-09-25', 'result' => 95];
        yield 'fix97' => ['basicCost' => 100, 'dateStart' => '2027-01-15', 'dateBirth' => '2000-05-11', 'datePayment' => '2026-10-25', 'result' => 97];
        yield 'fix90' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2008-05-11', 'datePayment' => '2023-11-25', 'result' => 90];
        yield 'fix70' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2013-05-11', 'datePayment' => '2023-11-25', 'result' => 70];
        yield 'fix70' => ['basicCost' => 100, 'dateStart' => '2027-05-01', 'dateBirth' => '2019-05-11', 'datePayment' => '2023-11-25', 'result' => 20];
    }

    public function testCreateAndCheck()
    {
        foreach ($this->provideData() as $data) {
            $travel = new Travel();
            $travel->setBasicCost($data['basicCost']);
            $travel->setDateBirth( \date_create($data['dateBirth']));
            $travel->setDatePayment(\date_create($data['datePayment']));
            $travel->setDateStart(\date_create($data['dateStart']));

            $result = $this->service->calculate($travel);

            self::assertNotNull($result);
            self::assertInstanceOf(Travel::class, $result);
            self::assertEquals($data['result'], $result->getFullCost());
        }


    }
}
