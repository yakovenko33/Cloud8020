<?php


namespace Tests\UserModule\Application;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserModule\Helpers\Traits\AddCarPark;
use Tests\UserModule\Helpers\Traits\UserSingIn;

class GetListCarTest extends TestCase
{
    use RefreshDatabase, UserSingIn, AddCarPark;

    public function testGetListCars(): void
    {
        $managerJwt = $this->addManagerCarPark();
        $driverJwt = $this->addDriverCarPark();

        $this->getCarsManager($managerJwt);
        $this->getCarsDrivers($driverJwt);
    }

    /**
     * @param string $jwt
     */
    private function getCarsManager(string $jwt): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $jwt)
            ->json("GET","/api/cars/list");
        $response->assertStatus(200);

        $data = (json_decode($response->getContent(),true))["data"];

        $this->assertEquals(count($data["cars"]), 4);
        $this->assertEquals(count($data["cars"][0]["car_parks"]), 1);
        $this->assertEquals(count($data["cars"][1]["car_parks"]), 1);
        $this->assertEquals(count($data["cars"][2]["car_parks"]), 0);
        $this->assertEquals(count($data["cars"][3]["car_parks"]), 0);
    }

    /**
     * @param string $jwt
     */
    private function getCarsDrivers(string $jwt): void
    {
        $response = $this->withHeader('Authorization', "Bearer " . $jwt)
            ->json("GET", "/api/cars/list");
        $response->assertStatus(200);

        $data = (json_decode($response->getContent(),true))["data"];

        $this->assertEquals(count($data["cars"]), 2);
        $this->assertEquals(count($data["cars"][0]["car_parks"]), 0);
        $this->assertEquals(count($data["cars"][1]["car_parks"]), 0);
    }
}
