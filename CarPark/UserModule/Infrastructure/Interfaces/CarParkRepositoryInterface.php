<?php


namespace CarPark\UserModule\Infrastructure\Interfaces;


use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\Car as CarDto;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark as CarParkDto;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
//use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Support\Collection;

interface CarParkRepositoryInterface
{
    /**
     * @param CarParkDto $carPark
     * @return CarPark|null
     */
    public function insertCarPark(CarParkDto $carPark): ?CarPark;

    /**
     * @param CarParkDto $carPark
     * @return CarPark|null
     */
    public function updateCarParkById(CarParkDto $carPark): ?CarPark;

    /**
     * @param CarDto $car
     * @param int $userId
     * @return Car|null
     */
    public function insertCar(CarDto $car, int $userId): ?Car;

    /**
     * @param CarDto $car
     * @param int $userId
     * @return Car|null
     */
    public function updateCarById(CarDto $car, int $userId): ?Car;

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

    /**
     * @param int|null $userId
     * @return Collection|null
     */
    public function getCarParksList(int $userId = null): ?Collection;

    /**
     * @param int|null $userId
     * @return Collection|null
     */
    public function getCarsList(int $userId = null): ?Collection;
}
