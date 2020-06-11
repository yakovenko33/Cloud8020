<?php


namespace Tests\UserModule\Application;


use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UserModule\Helpers\Traits\AddCarPark;
use Tests\UserModule\Helpers\Traits\UserSingIn;

class DeleteCarTest extends TestCase
{
    use RefreshDatabase, UserSingIn, AddCarPark;

    public function testDeleteManager(): void
    {
        $jwt = $this->addManagerCarPark();
        $defaultData = [
            "number_car" => "number_2",
            "driver_name" => "Surname Name 2"
        ];

        $this->assertDatabaseHas('cars', $defaultData);
        $car = Car::where($defaultData)->first();

        $response = $this->withHeader(
            "Authorization", "Bearer $jwt"
        )->deleteJson("/api/car", ["id" => $car->id]);

        $response->assertStatus(202);
        $this->assertDatabaseMissing('cars', $defaultData);
    }

    public function testDeleteDriver(): void
    {
        $jwt = $this->addDriverCarPark();
        $defaultData = [
            "number_car" => "number_3",
            "driver_name" => "Surname Name 3"
        ];

        $this->assertDatabaseHas("cars", $defaultData);
        $car = Car::where($defaultData)->first();

        $response = $this->withHeader("Authorization", "Bearer $jwt")
            ->deleteJson("/api/car", ["id" => $car->id]);

        $response->assertStatus(403);
        $this->assertDatabaseHas("cars", $defaultData);
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
                "errors",
                null
            ],
            [
                [
                    "id" => [
                        "Данной машины не существует"
                    ]
                ],
                422,
                "errors",
                100
            ],
            [
                [
                    "id" => [
                        "Параметр должен быть числом"
                    ]
                ],
                422,
                'errors',
                Str::random(10),
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     * @param array $errors
     * @param int $statusCode
     * @param string $status
     * @param null $request
     */
    public function testValidateDeleteCar(array $errors, int $statusCode, string $status, $request = null): void
    {
        $response = $this->withHeader("Authorization", "Bearer " . $this->singIn())
            ->deleteJson("/api/car", ["id" => $request]);

        $response
            ->assertStatus($statusCode)
            ->assertExactJson([
                "data" => [],
                "errors" => $errors,
                "status" => $status
            ]);
    }
}
