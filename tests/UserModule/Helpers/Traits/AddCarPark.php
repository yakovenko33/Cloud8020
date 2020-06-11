<?php


namespace Tests\UserModule\Helpers\Traits;


use Tests\UserModule\Helpers\DataClasses\Car;
use Tests\UserModule\Helpers\Factories\AddCarParkFactory;

trait AddCarPark
{
    /**
     * @return string
     */
    protected function addManagerCarPark(): string
    {
        $managerJwt = $this->singIn();
        $addCarPark = AddCarParkFactory::creatDefault();
        $addCarPark->addCar(new Car("number_2", "Surname Name 2"));

        $responseManager = $this->withHeader('Authorization', 'Bearer ' . $managerJwt)
            ->json("POST","/api/car-park", $addCarPark->toArray());
        $responseManager->assertStatus(201);

        return $managerJwt;
    }

    /**
     * @return string
     */
    protected function addDriverCarPark(): string
    {
        $driverJwt = $this->singIn("test_driver@gmail.com", "password_driver");
        $addCarPark = AddCarParkFactory::creatDefault();
        $addCarPark->addCar(new Car("number_4", "Surname Name 4"))
            ->changeNameDriverForIndex(0, "Surname Name 3")
            ->changeNumberCarForIndex(0,"number_3");

        $responseDriver = $this->withHeader('Authorization', 'Bearer ' .  $driverJwt)
            ->json("POST","/api/car-park", $addCarPark->toArray());
        $responseDriver->assertStatus(201);

        return $driverJwt;
    }
}
