<?php


namespace CarPark\CarParkModule\Application\DeleteCar\Middleware;


use CarPark\CommonModule\Bus\Validator\ValidatorRoot;

class DeleteCarValidator extends ValidatorRoot
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'id' => "required|integer|exists:cars,id",
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
