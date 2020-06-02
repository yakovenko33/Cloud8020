<?php


namespace CarPark\UserModule\Infrastructure\Interfaces;


use CarPark\UserModule\Application\CreateCarsPark\DTO\Car as CarDto;
use CarPark\UserModule\Application\CreateCarsPark\DTO\CarPark as CarsParkDto;
use CarPark\UserModule\Infrastructure\Modals\Car;
use CarPark\UserModule\Infrastructure\Modals\CarPark;

interface CarParkRepositoryInterface
{
    /**
     * @param CarsParkDto $carsPark
     * @return CarPark|null
     */
    public function insertCarsPark(CarsParkDto $carsPark): ?CarPark;

    /**
     * @param CarsParkDto $carsPark
     * @return CarPark|null
     */
    public function updateCarsParkById(CarsParkDto $carsPark): ?CarPark;

    /**
     * @param CarDTO $car
     * @return Car|null
     */
    public function insertCar(CarDto $car): ?Car;

    /**
     * @param CarDto $car
     * @return Car|null
     */
    public function updateCarById(CarDto $car): ?Car;
}
