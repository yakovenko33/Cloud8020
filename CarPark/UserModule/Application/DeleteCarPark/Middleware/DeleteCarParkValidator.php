<?php


namespace CarPark\UserModule\Application\DeleteCarPark\Middleware;


use CarPark\CommonModule\Bus\Validator\ValidatorRoot;

class DeleteCarParkValidator extends ValidatorRoot
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
            "id.exists" => "Данного парка не существует"
        ];
    }
}
