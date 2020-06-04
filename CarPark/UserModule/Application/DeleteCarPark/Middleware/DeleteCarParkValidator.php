<?php


namespace CarPark\UserModule\Application\DeleteCarPark\Middleware;


class DeleteCarParkValidator
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id' => "required|integer|exists:car_parks,id",
        ];
    }

    /**
     * @return array
     */
    protected function getMessagesValidator(): array
    {
        return [
            "id.required" => "Параметр обязательный",
            "id.integer" => "Параметр должен быть числом",
            "id.exists" => "Данной машины не существует"
        ];
    }
}
