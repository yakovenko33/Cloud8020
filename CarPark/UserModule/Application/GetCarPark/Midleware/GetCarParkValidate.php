<?php


namespace CarPark\UserModule\Application\GetCarPark\Midleware;


use CarPark\CommonModule\Bus\Validator\ValidatorRoot;

class GetCarParkValidate extends ValidatorRoot
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            "car_park_id" => "bail|nullable|integer|exist:car_parks,id", //required|
            "car_id" => "bail|nullable|integer|exist:cars,id"
        ];
    }

    /**
     * @return array
     */
    protected function getMessagesValidator(): array
    {
        return [
            "car_park_id.exists" => "Данной машины не существует",
            "car_id.exists" => "Данной машины не существует"
        ];
    }
}
