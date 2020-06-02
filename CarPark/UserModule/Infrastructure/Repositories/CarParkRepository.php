<?php


namespace CarPark\UserModule\Infrastructure\Repositories;


use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark as CarParkDto;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use \CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\Car as CarDto;

class CarParkRepository implements CarParkRepositoryInterface
{
    /**
     * @param CarParkDto $carsPark
     * @return CarPark|null
     */
    public function insertCarsPark(CarParkDto $carsPark): ?CarPark
    {
        try {
            $result = CarPark::create([
                "title" => $carsPark->getTitle(),
                "address" => $carsPark->getAddress(),
                "time_work" => $carsPark->getTimeWork()
            ]);
            $result->save();
        } catch(QueryException $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param CarParkDto $carsPark
     * @return CarPark|null
     */
    public function updateCarsParkById(CarParkDto $carsPark): ?CarPark
    {
        try {
            $result = CarPark::where(["id" => $carsPark->getId()])->first();
            $result->title = $carsPark->getTitle();
            $result->address = $carsPark->getAddress();
            $result->time_work = $carsPark->getTimeWork();
            $result->save();
        } catch(QueryException $e) {
            Log::error($e->getMessage(). $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param CarDTO $car
     * @return Car|null
     */
    public function insertCar(CarDto $car): ?Car
    {
        try {
            $result = Car::create([
                "number_car" => $car->getNumberCar(),
                "name_drive" => $car->getNameDriver()
            ]);
            $result->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage() . $e);
            $result = null;
        }

        return $result;
    }

    /**
     * @param CarDto $car
     * @return Car|null
     */
    public function updateCarById(CarDto $car): ?Car
    {
        try {
            $result = Car::where(["id" => $car->getId()])->first();
            $result->number_car = $car->getNumberCar();
            $result->name_drive = $car->getNameDriver();
            $result->save();
        } catch (QueryException $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteCarParkById(int $id): bool
    {
        try {
            CarPark::where('id', $id)->delete();
            $result = true;
        } catch (QueryException $e) {
            Log::error($e->getMessage(). $e->getTraceAsString());
            $result = false;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteCarById(int $id): bool
    {
        try {
            Car::where('id', $id)->delete();
            $result = true;
        } catch (QueryException $e) {
            Log::error($e->getMessage(). $e->getTraceAsString());
            $result = false;
        }

        return $result;
    }
}
