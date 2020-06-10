<?php


namespace Tests\UserModule\Application;


use CarPark\UserModule\Infrastructure\Laravel\Database\Seeders\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tests\UserModule\Helpers\DataProvider\ValidateCarPark;
use Tests\UserModule\Helpers\DataProvider\ValidateCars;
use Tests\UserModule\Helpers\Factories\AddCarParkFactory;
use Tests\UserModule\Helpers\Mocks\AddCarPark;

class CreateOrUpdateCarParkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function carParkData(): array
    {
        return ValidateCarPark::getData();
    }

    /**
     * @dataProvider carParkData
     * @param AddCarPark $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    public function testCarParkValidate(AddCarPark $request, array $errors, string $status, int $statusCode): void
    {
        $this->requestAddUpdateCarPark(
            $request,
            $errors,
            $status,
            $statusCode
        );
    }

    /**
     * @return array
     */
    public function carsData(): array
    {
        return ValidateCars::getData();
    }

    /**
     * @dataProvider carsData
     * @param AddCarPark $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    public function testCarsValidate(AddCarPark $request, array $errors, string $status, int $statusCode): void
    {
        $this->requestAddUpdateCarPark(
            $request,
            ["cars_errors" => [$errors]],
            $status,
            $statusCode
        );
    }

    public function testAddCarParkManager(): void
    {
        $carPark = AddCarParkFactory::creatDefault();
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->singIn())
            ->json("POST","/api/car-park", $carPark->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseHas("car_parks", [
            'title' => $carPark->getCarPark()->getTitle(),
            'address' => $carPark->getCarPark()->getAddress()
        ]);

        $this->assertDatabaseHas("cars",[
            "number_car" => $carPark->getCars()[0]->getNumberCar(),
            "driver_name" => $carPark->getCars()[0]->getNameDriver()
        ]);
    }

    public function testAddCarParkDriver(): void
    {
        $carPark = AddCarParkFactory::creatDefault();

        $response = $this->withHeader(
            'Authorization',
            'Bearer ' . $this->singIn("test_driver@gmail.com", "password_driver")
        )->json("POST","/api/car-park", $carPark->toArray());

        $response->assertStatus(201);

        $this->assertDatabaseMissing("car_parks", [
            'title' => $carPark->getCarPark()->getTitle(),
            'address' => $carPark->getCarPark()->getAddress()
        ]);

        $this->assertDatabaseHas("cars",[
            "number_car" => $carPark->getCars()[0]->getNumberCar(),
            "driver_name" => $carPark->getCars()[0]->getNameDriver()
        ]);
    }

    /**
     * @param AddCarPark $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    private function requestAddUpdateCarPark(AddCarPark $request, array $errors, string $status, int $statusCode): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->singIn())
            ->json("POST", "/api/car-park", $request->toArray());

        $response
            ->assertStatus($statusCode)
            ->assertExactJson([
                "data" => [],
                "errors" => $errors,
                "status" => $status
            ]);
    }

    /**
     * @param string $email
     * @param string $password
     * @return string
     */
    private function singIn(string $email = "test_manager@gmail.com", string $password = "password_manager"): string
    {
        Artisan::call('db:seed', ["--class" => User::class]);

        $response = $this->json("POST", "/api/user/sing-in", [
            "email" => $email,
            "password" => $password
        ]);

        $result = json_decode($response->content(), true);

        return $result["data"]["jwt_token"];
    }
}
