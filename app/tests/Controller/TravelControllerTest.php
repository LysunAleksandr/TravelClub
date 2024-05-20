<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TravelControllerTest extends WebTestCase
{
    public function provideJson(): iterable
    {
        yield ['json' => '{"basicCost": 100,"dateStart": "2027-05-01","dateBirth": "2000-05-11","datePayment": "2026-11-25"}', 'result' => Response::HTTP_OK];
    }

    /**
     * @dataProvider provideJson
     */
    public function testCalculatePriceAction($data, $result)
    {
        $client = static::createClient();

            $client->request('POST', '/api/v1/travel/calculate',
                [],
                [],
                ['Content-Type' => 'application/json'],
                $data
            );
            $this->assertEquals($result, $client->getResponse()->getStatusCode());
    }
}