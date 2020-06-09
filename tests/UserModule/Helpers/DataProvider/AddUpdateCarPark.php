<?php


namespace Tests\UserModule\Helpers\DataProvider;


use Illuminate\Support\Str;
use Tests\UserModule\Helpers\DataClasses\AddCarPark;
use Tests\UserModule\Helpers\DataClasses\Car;
use Tests\UserModule\Helpers\DataClasses\CarPark;
use Tests\UserModule\Helpers\Factories\AddCarParkFactory;

class AddUpdateCarPark
{
    public static function getData(): array
    {
        $request = AddCarParkFactory::creatDefault();

        return [
            [
                (clone $request)->changeTitleCarPark(),
                [
                    "title" => [
                        "Название автопарка обязательное поле"
                    ]
                ],
                "errors",
                422
            ],
            [
                (clone $request)->changeTitleCarPark(Str::random(51)),
                [
                    "title" => [
                        "Длина названия автопарка превышает 50 символов"
                    ]
                ],
                "errors",
                422
            ],
            [
                (clone $request)->changeAddressCarPark(""),
                [
                    "address" => [
                        "Адресс автопарка обязательный"
                    ]
                ],
                "errors",
                422,
            ],
            [
                (clone $request)->changeAddressCarPark(Str::random(81)),
                [
                    "address" => [
                        "Длина адресса автопарка превышает 80 символов"
                    ]
                ],
                "errors",
                422,
            ],
            [
                (clone $request)->changeTimeWork(""),
                [
                    "time_work" => [
                        "Время работы обязательное"
                    ]
                ],
                "errors",
                422,
            ],
            [
                (clone $request)->changeTimeWork(Str::random(101)),
                [
                    "time_work" => [
                        "Длина времени работы превышает 100 символов"
                    ]
                ],
                "errors",
                422,
            ]
        ];
    }

    /**
     * @return AddCarPark
     */
    private static function createAddCarPark(): AddCarPark
    {
        return new AddCarPark(
            new CarPark(
                "Автопарк Черкассы Мытница",
                "Черкассы, ул. Мытница 126",
                "пн-вс 9:00 - 18:00"
            ),
            [new Car("number_1", "Surname Name")]
        );
    }
}
