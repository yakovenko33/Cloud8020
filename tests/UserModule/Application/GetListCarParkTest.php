<?php


namespace Tests\UserModule\Application;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserModule\Helpers\Traits\AddCarPark;
use Tests\UserModule\Helpers\Traits\UserSingIn;

class GetListCarParkTest extends TestCase
{
    use RefreshDatabase, UserSingIn, AddCarPark;

    public function testGetCarParksList(): void
    {
        $managerJwt = $this->addManagerCarPark();
        $driverJwt = $this->addDriverCarPark();

        $this->getCarParksListManager($managerJwt);
        $this->getCarParksListDriver($driverJwt);
    }

    /**
     * @param string $managerJwt
     */
    private function getCarParksListManager(string $managerJwt): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $managerJwt)
            ->json("GET","/api/car-parks/list");

        $response->assertStatus(200);
        $data = (json_decode($response->content(), true))["data"];

        $this->assertEquals(count($data["car_parks"]), 1);
        $this->assertEquals(count($data["car_parks"][0]["cars"]), 2);
    }

    /**
     * @param string $managerJwt
     */
    private function getCarParksListDriver(string $managerJwt): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $managerJwt)
            ->json("GET","/api/car-parks/list");

        $response->assertStatus(200);
        $data = (json_decode($response->content(), true))["data"];

        $this->assertEquals(count($data["car_parks"]), 1);
    }
}
