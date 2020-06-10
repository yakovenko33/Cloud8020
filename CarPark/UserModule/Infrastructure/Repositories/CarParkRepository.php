<?php


namespace CarPark\UserModule\Infrastructure\Repositories;


use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark as CarParkDto;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Car;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
//use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use \CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\Car as CarDto;
use \Illuminate\Support\Collection;

class CarParkRepository implements CarParkRepositoryInterface
{
    /**
     * @param CarParkDto $carsPark
     * @return CarPark|null
     */
    public function insertCarPark(CarParkDto $carsPark): ?CarPark
    {
        try {
            $result = CarPark::create([
                "title" => $carsPark->getTitle(),
                "address" => $carsPark->getAddress(),
                "time_work" => $carsPark->getTimeWork(),
                "created_at" => Carbon::now()
            ]);
            $result->save();
        } catch(QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param CarParkDto $carsPark
     * @return CarPark|null
     */
    public function updateCarParkById(CarParkDto $carsPark): ?CarPark
    {
        try {
            $result = CarPark::where(["id" => $carsPark->getId()])->first();
            $result->title = $carsPark->getTitle();
            $result->address = $carsPark->getAddress();
            $result->time_work = $carsPark->getTimeWork();
            $result->save();
        } catch(QueryException $e) {
            Log::debug($e->getMessage(). $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }



    /**
     * @param CarDto $car
     * @param int $userId
     * @return Car|null
     */
    public function insertCar(CarDto $car, int $userId): ?Car
    {
        try {
            $result = Car::create([
                "number_car" => $car->getNumberCar(),
                "driver_name" => $car->getNameDriver(),
                "user_id" => $userId,
                "created_at" => Carbon::now()
            ]);
            $result->save();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e);
            $result = null;
        }

        return $result;
    }

    /**
     * @param CarDto $car
     * @param int $userId
     * @return Car|null
     */
    public function updateCarById(CarDto $car, int $userId): ?Car
    {
        try {
            $result = Car::where(["id" => $car->getId()])->first();
            $result->number_car = $car->getNumberCar();
            $result->driver_name = $car->getNameDriver();
            $result->user_id = $userId;
            $result->save();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
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
            Log::debug($e->getMessage(). $e->getTraceAsString());
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
            Log::debug($e->getMessage(). $e->getTraceAsString());
            $result = false;
        }

        return $result;
    }

    /**
     * @param int|null $userId
     * @return Collection|null
     */
    public function getCarParksList(int $userId = null): ?Collection
    {
        try {
            $result = (empty($userId))
                ? CarPark::with('cars')->get()
                : CarPark::with(['cars' => function($query) use ($userId) {
                    $query->where("user_id", $userId);
                }])->get();
        } catch (QueryException $e) {
            Log::info($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param int|null $userId
     * @return Collection|null
     */
    public function getCarsList(int $userId = null): ?Collection
    {
        try {
            $result = (empty($userId))
                ? Car::with("carParks")->get()
                : Car::where('user_id', $userId)->with("carParks")->get();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }
}
