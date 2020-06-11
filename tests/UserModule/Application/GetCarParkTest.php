<?php


namespace Tests\UserModule\Application;


use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\UserModule\Helpers\Traits\AddCarPark;
use Tests\UserModule\Helpers\Traits\UserSingIn;

class GetCarParkTest extends TestCase
{
    use RefreshDatabase, UserSingIn, AddCarPark;

    public function testGetCarParkManager(): void
    {
        $jwt = $this->addManagerCarPark();

        $defaultData = [
            "title" => "Автопарк Черкассы Мытница",
            "address" => "Черкассы, ул. Мытница 126",
        ];

        $carPark = CarPark::where($defaultData)->first();

        $response = $this->withHeader("Authorization", "Bearer $jwt")
            ->json("GET", "/api/car-park", ["car_park_id" => $carPark->id]);
        $response->assertStatus(200);

        $data = (json_decode($response->getContent(), true))["data"];

        $this->assertEquals($data["car_park"]["title"], $defaultData["title"]);
        $this->assertEquals($data["car_park"]["address"], $defaultData["address"]);
        $this->assertEquals(count($data["car_park"]["cars"]), 2);
    }

    public function testGetCarManager(): void
    {
        $jwt = $this->addManagerCarPark();

        $defaultData = [
            "number_car" => "number_2",
            "driver_name" => "Surname Name 2",
        ];

        $car = Car::where($defaultData)->first();

        $response = $this->withHeader("Authorization", "Bearer $jwt")
            ->json("GET", "/api/car-park", ["car_id" => $car->id]);
        $response->assertStatus(200);

        $data = (json_decode($response->getContent(), true))["data"];

        $this->assertEquals($data["car"]["number_car"], $defaultData["number_car"]);
        $this->assertEquals($data["car"]["driver_name"], $defaultData[ "driver_name" ]);
    }

    public function testGetCarDriver(): void
    {
        $jwt = $this->addDriverCarPark();

        $defaultData = [
            "number_car" => "number_4",
            "driver_name" => "Surname Name 4",
        ];

        $car = Car::where($defaultData)->first();

        $response = $this->withHeader("Authorization", "Bearer $jwt")
            ->json("GET", "/api/car-park", ["car_id" => $car->id]);
        $response->assertStatus(200);

        $data = (json_decode($response->getContent(), true))["data"];

        $this->assertEquals($data["car"]["number_car"], $defaultData["number_car"]);
        $this->assertEquals($data["car"]["driver_name"], $defaultData[ "driver_name" ]);
    }

    public function testGetCarParkDataBad(): void
    {
        $response = $this->withHeader("Authorization", "Bearer " . $this->singIn())
            ->json("GET", "/api/car-park", ["car_id" => 1, "car_park_id" => 1]);
        $response->assertStatus(422);
    }

    public function testGetCarParkDataBadEmpty(): void
    {
        $response = $this->withHeader("Authorization", "Bearer " . $this->singIn())
            ->json("GET", "/api/car-park", ["car_id" => null, "car_park_id" => null]);
        $response->assertStatus(422);
    }

    public function testDriverGetCarPark(): void
    {
        $this->addManagerCarPark();
        $jwt = $this->singIn("test_driver@gmail.com", "password_driver");

        $response = $this->withHeader("Authorization", "Bearer " . $jwt)
            ->json("GET", "/api/car-park", ["car_park_id" => 1]);
        $response->assertStatus(403);
    }

    /**
     * @return array
     */
    public function dataCarPark(): array
    {
        return [
            [
                1,
                [
                    "car_park_id" => [
                        "Данной автопарка не существует"
                    ]
                ],
                "errors",
                422
            ],
            [
                Str::random(10),
                [
                    "car_park_id" => [
                        "Поле должно быть целочисельным"
                    ]
                ],
                "errors",
                422
            ]
        ];
    }

    /**
     * @dataProvider dataCarPark
     * @param $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    public function testCarParkValidate($request, array $errors, string $status, int $statusCode): void
    {
        $response = $this->withHeader("Authorization", "Bearer " . $this->singIn())
            ->json("GET", "/api/car-park", ["car_park_id" => $request]);

        $response
            ->assertStatus($statusCode)
            ->assertExactJson([
                "data" => [],
                "errors" => $errors,
                "status" => $status
            ]);
    }

    /**
     * @return array
     */
    public function dataCar(): array
    {
        return [
            [
                1,
                [
                    "car_id" => [
                        "Данной машины не существует"
                    ]
                ],
                "errors",
                422
            ],
            [
                Str::random(10),
                [
                    "car_id" => [
                        "Поле должно быть целочисельным"
                    ]
                ],
                "errors",
                422
            ]
        ];
    }

    /**
     * @dataProvider dataCar
     * @param $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    public function testCarValidate($request, array $errors, string $status, int $statusCode): void
    {
        $response = $this->withHeader("Authorization", "Bearer " . $this->singIn())
            ->json("GET", "/api/car-park", ["car_id" => $request]);

        $response
            ->assertStatus($statusCode)
            ->assertExactJson([
                "data" => [],
                "errors" => $errors,
                "status" => $status
            ]);
    }
}
