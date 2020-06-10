<?php


namespace Tests\UserModule\Helpers\DataProvider;


use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User;

class DefaultDataCarPark
{
    /**
     * @return array
     */
    public function getData(User $user): array
    {
        $carPark = CarPark::create([
            "title" => "Test title",
            "address" => "Test address",
            "time_work" => "Test time work"
        ]);
        $carPark->save();

        return [
            "car_park" => $carPark,
            "cars" => $this->addCars($carPark),
        ];
    }

    /**
     * @param CarPark $carPark
     * @return array
     */
    private function addCars(CarPark $carPark): array
    {
        $cars = [];
        $listId = [];
        for ($i = 0; $i < 5; $i++) {
            $car = Car::create([
                "number_car" => "Test number",
                "driver_name" => "Test driver_name"
            ]);
            $car->save();

            $cars[] = $car;
            $listId[] = $car->id;
        }

        $carPark->cars()->attach($listId);

        return $cars;
    }
}
