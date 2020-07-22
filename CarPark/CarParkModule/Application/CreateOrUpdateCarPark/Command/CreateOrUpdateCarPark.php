<?php


namespace CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Command;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\DTO\Car;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\DTO\CarPark;

class CreateOrUpdateCarPark extends VerifyCommandQuery implements CommandQueryInterface
{
    /**
     * @var CarPark|null
     */
    private $carPark;

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
        $this->carPark = array_key_exists("car_park", $data) ? new CarPark($data["car_park"]) : null;
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
     * @return CarPark|null
     */
    public function getCarPark(): ?CarPark
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            "car_par" => $this->carPark,
            "cars" => $this->cars
        ];
    }
}
