<?php


namespace Tests\UserModule\UI;


use CarPark\UserModule\Infrastructure\Laravel\Database\Seeders\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;
use Tests\UserModule\Helpers\DataClasses\AddCarPark;
use Tests\UserModule\Helpers\DataClasses\Car;
use Tests\UserModule\Helpers\DataClasses\CarPark;
use Tests\UserModule\Helpers\DataProvider\AddUpdateCarPark;
use Tests\UserModule\Helpers\DataProvider\AddUpdateCars;
use Tests\UserModule\Helpers\Factories\AddCarParkFactory;

class CarParkController extends TestCase
{
    /**
     * @return array
     */
    public function carParkData(): array
    {
        return AddUpdateCarPark::getData();
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
        return AddUpdateCars::getData();
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

//    private function testAddCarPark(): void
//    {
//        $response = $this->withHeader('Authorization', 'Bearer ' . $this->singInManager())
//            ->json("POST","/api/car-park", AddCarParkFactory::creatDefault()->toArray());
//    }

    /**
     * @param AddCarPark $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    private function requestAddUpdateCarPark(AddCarPark $request, array $errors, string $status, int $statusCode): void
    {
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->singInManager())
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
     * @return string
     */
    private function singInManager(): string
    {
        Artisan::call('db:seed', ["--class" => User::class]);

        $response = $this->json("POST", "/api/user/sing-in", [
            "email" => "test_manager@gmail.com",
            "password" => "password_manager"
        ]);

        $result = json_decode($response->content(), true);

        return $result["data"]["jwt_token"];
    }
}
