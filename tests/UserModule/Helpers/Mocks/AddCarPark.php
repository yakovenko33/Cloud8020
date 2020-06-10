<?php


namespace Tests\UserModule\Helpers\Mocks;


use Tests\UserModule\Helpers\DataClasses\Car;
use Tests\UserModule\Helpers\DataClasses\CarPark;

class AddCarPark
{
    /**
     * @var CarPark
     */
    private $carPark;

    /**
     * @var array
     */
    private $cars;

    /**
     * AddCarPark constructor.
     * @param CarPark $carPark
     * @param array $cars
     */
    public function __construct(CarPark $carPark, array $cars)
    {
        $this->carPark = $carPark;
        $this->cars = $cars;
    }

    public function __clone()
    {
        $this->carPark = clone $this->carPark;
        $cars = [];
        foreach($this->cars as $key => $car) {
            $cars[$key] = clone $car;
        }

        $this->cars = $cars;
    }

    /**
     * @param string $string
     * @return $this
     */
    public function changeTitleCarPark(string $string = ""): self
    {
        $this->carPark->setTitle($string);

        return $this;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function changeAddressCarPark(string $address = ""): self
    {
        $this->carPark->setAddress($address);

        return $this;
    }

    /**
     * @param string $timeWork
     * @return $this
     */
    public function changeTimeWork(string $timeWork = ""): self
    {
        $this->carPark->setTimeWork($timeWork);

        return $this;
    }

    /**
     * @return CarPark
     */
    public function getCarPark(): CarPark
    {
        return $this->carPark;
    }

    /**
     * @return array
     */
    public function getCars(): array
    {
        return $this->cars;
    }

    /**
     * @param int $index
     * @param string $numberCar
     * @return $this
     */
    public function changeNumberCarForIndex(int $index, string $numberCar = ""): self
    {
        $this->cars[$index]->setNumberCar($numberCar);

        return $this;
    }

    /**
     * @param int $index
     * @param string $nameDriver
     * @return $this
     */
    public function changeNameDriverForIndex(int $index, string $nameDriver = ""): self
    {
        $this->cars[$index]->setNameDriver($nameDriver);

        return $this;
    }

    /**
     * @param Car $car
     * @return $this
     */
    public function addCar(Car $car): self
    {
        $this->cars[] = $car;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "car_park" => $this->carPark->toArray(),
            "cars" => $this->carsToArray()
        ];
    }

    /**
     * @return array
     */
    private function carsToArray(): array
    {
        $cars = [];
        foreach($this->cars as $car) {
            $cars[] = $car->toArray();
        }

        return $cars;
    }
}
