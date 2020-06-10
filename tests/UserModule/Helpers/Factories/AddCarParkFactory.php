<?php


namespace Tests\UserModule\Helpers\Factories;


use Tests\UserModule\Helpers\Mocks\AddCarPark;
use Tests\UserModule\Helpers\DataClasses\Car;
use Tests\UserModule\Helpers\DataClasses\CarPark;

class AddCarParkFactory
{
    /**
     * @return AddCarPark
     */
    public static function creatDefault(): AddCarPark
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
