<?php


namespace CarPark\CarParkModule\Application\GetCarPark\Midleware;


use CarPark\CommonModule\Bus\Validator\ValidatorRoot;

class GetCarParkValidate extends ValidatorRoot
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            "car_park_id" => "nullable|integer|bail|exists:car_parks,id",
            "car_id" => "nullable|integer|bail|exists:cars,id"
        ];
    }

    /**
     * @return array
     */
    protected function getMessagesValidator(): array
    {
        return [
            "car_park_id.exists" => "Данной автопарка не существует",
            "car_park_id.integer" => "Поле должно быть целочисельным",
            "car_id.exists" => "Данной машины не существует",
            "car_id.integer" => "Поле должно быть целочисельным",
        ];
    }
}
