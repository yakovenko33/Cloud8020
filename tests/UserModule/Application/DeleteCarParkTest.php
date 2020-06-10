<?php


namespace Tests\UserModule\Application;


use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserModule\Helpers\Traits\AddCarPark;
use Tests\UserModule\Helpers\Traits\UserSingIn;

class DeleteCarParkTest extends TestCase
{
    use RefreshDatabase, UserSingIn, AddCarPark;

    /**
     * @var array
     */
    private $defaultCarParkData = [
        "title" => "Автопарк Черкассы Мытница",
        "address" => "Черкассы, ул. Мытница 126"
    ];

    public function testDeleteParkManager(): void
    {
        $jwt = $this->addManagerCarPark();
        $this->assertDatabaseHas("car_parks", $this->defaultCarParkData);

        $this->hasCarsDatabase();
        $carPark = CarPark::where($this->defaultCarParkData)->first();

        $response = $this->withHeader('Authorization', 'Bearer ' . $jwt)
            ->deleteJson( "/api/car-park", ["id" => $carPark->id]); //1

        $response->assertStatus(202);
        $this->assertDatabaseMissing("car_parks", $this->defaultCarParkData);
    }

    public function testDeleteParkDriver(): void
    {
        $this->addManagerCarPark();
        $jwt = $this->singIn("test_driver@gmail.com", "password_driver");

        $this->assertDatabaseHas("car_parks", $this->defaultCarParkData);

        $this->hasCarsDatabase();
        $carPark = CarPark::where($this->defaultCarParkData)->first();

        $response = $this->withHeader('Authorization', 'Bearer ' . $jwt)
            ->deleteJson( "/api/car-park", ["id" => $carPark->id]);

        $response->assertStatus(403);
        $this->assertDatabaseHas("car_parks", $this->defaultCarParkData);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                [
                    "id" => [
                        "Параметр обязательный"
                    ]
                ],
                422,
                'errors',
                null,
            ],
            [
                [
                    "id" => [
                        "Данного парка не существует"
                    ]
                ],
                422,
                'errors',
                100,
            ],
            [
                [
                    "id" => [
                        "Данного парка не существует"
                    ]
                ],
                422,
                'errors',
            ]
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param int $request
     * @param array $errors
     * @param int $statusCode
     * @param string $status
     */
    public function testValidateDeleteCarPark(array $errors, int $statusCode, string $status, int $request = null): void
    {
        $response = $this->withHeader(
            "Authorization", "Bearer " . $this->singIn()
        )->deleteJson("/api/car-park",["id" => $request]);

        $response
            ->assertStatus($statusCode)
            ->assertExactJson([
                "data" => [],
                "errors" => $errors,
                "status" => $status
            ]);
    }


    private function hasCarsDatabase(): void
    {
        $this->assertDatabaseHas("cars", [
            "number_car" => "number_1",
            "driver_name" => "Surname Name"
        ]);

        $this->assertDatabaseHas("cars", [
            "number_car" => "number_2",
            "driver_name" => "Surname Name 2"
        ]);
    }
}
