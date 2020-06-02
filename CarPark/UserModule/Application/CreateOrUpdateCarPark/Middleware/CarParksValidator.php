<?php


namespace CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware;


use CarPark\CommonModule\Bus\Validator\ValidatorRoot;

class CarParksValidator extends ValidatorRoot
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            "title" => "required|string|max:50",
            "address" => "required|string|max:80",
            "time_work" => "required|string|max:100"
        ];
    }

    /**
     * @return array
     */
    protected function getMessagesValidator(): array
    {
        return [
            "title.required" => "Название автопарка обязательное поле",
            "title.max" => "Длина названия автопарка превышает :max символов",
            "address.required" => "Адресс автопарка обязательный",
            "address.max" => "Длина адресса автопарка превышает :max символов",
            "time_work.required" => "Время работы обязательное",
            "time_work.max" => "Длина времени работы превышает :max символов"
        ];
    }
}
