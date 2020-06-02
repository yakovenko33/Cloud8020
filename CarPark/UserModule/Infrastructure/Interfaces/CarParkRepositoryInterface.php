<?php


namespace CarPark\UserModule\Infrastructure\Interfaces;


use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\Car as CarDto;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark as CarParkDto;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;

interface CarParkRepositoryInterface
{
    /**
     * @param CarParkDto $carPark
     * @return CarPark|null
     */
    public function insertCarsPark(CarParkDto $carPark): ?CarPark;

    /**
     * @param CarParkDto $carPark
     * @return CarPark|null
     */
    public function updateCarsParkById(CarParkDto $carPark): ?CarPark;

    /**
     * @param CarDto $car
     * @return Car|null
     */
    public function insertCar(CarDto $car): ?Car;

    /**
     * @param CarDto $car
     * @return Car|null
     */
    public function updateCarById(CarDto $car): ?Car;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteCarParkById(int $id): bool;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteCarById(int $id): bool;
}
