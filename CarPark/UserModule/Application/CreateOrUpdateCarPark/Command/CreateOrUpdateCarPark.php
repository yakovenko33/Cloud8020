<?php


namespace CarPark\UserModule\Application\CreateOrUpdateCarPark\Command;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\Car;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark;

class CreateOrUpdateCarPark extends VerifyCommandQuery implements CommandQueryInterface
{
    /**
     * @var CarPark
     */
    private $carsPark;

    /**
     * @var array
     */
    private $cars = [];

    /**
     * CreateOrUpdateCarParkHandler constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data["jwt"]);
        $this->carsPark = new CarPark($data["cars_park"]);
        $this->setCars($data["cars"]);
    }

    /**
     * @param array $cars
     */
    private function setCars(array $cars): void
    {
        foreach($cars as $car) {
            $this->cars[] = new Car($car);
        }
    }

    /**
     * @return CarPark
     */
    public function getCarsPark(): CarPark
    {
        return $this->carsPark;
    }

    /**
     * @return array
     */
    public function getCars(): array
    {
        return $this->cars;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->carsPark->toArray();
    }
}
