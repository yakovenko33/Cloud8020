<?php


namespace Tests\UserModule\Helpers\DataProvider;


use Illuminate\Support\Str;
use Tests\UserModule\Helpers\DataClasses\AddCarPark;
use Tests\UserModule\Helpers\DataClasses\Car;
use Tests\UserModule\Helpers\DataClasses\CarPark;
use Tests\UserModule\Helpers\Factories\AddCarParkFactory;

class ValidateCars
{
    /**
     * @return array
     */
    public static function getData(): array
    {
        $request = AddCarParkFactory::creatDefault();

        return [
            [
                (clone $request)->changeNumberCarForIndex(0),
                [
                    "number_car" => [
                        "Номер машины обязательный"
                    ]
                ],
                "errors",
                422
            ],
            [
                (clone $request)->changeNumberCarForIndex(0, Str::random(16)),
                [
                    "number_car" => [
                        "Длина номера машины превышает 15 символов"
                    ]
                ],
                "errors",
                422
            ],
            [
                (clone $request)->changeNameDriverForIndex(0, ""),
                [
                    "name_driver" => [
                        "Имя водителя обязательное"
                    ]
                ],
                "errors",
                422
            ],
            [
                (clone $request)->changeNameDriverForIndex(0, Str::random(76)),
                [
                    "name_driver" => [
                        "Длина имени водителя превышает 75 символов"
                    ]
                ],
                "errors",
                422
            ],
        ];
    }
}
