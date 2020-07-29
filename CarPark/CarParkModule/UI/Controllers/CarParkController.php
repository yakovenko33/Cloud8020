<?php


namespace CarPark\CarParkModule\UI\Controllers;


use CarPark\CarParkModule\Application\DeleteCarPark\Middleware\DeleteCarParkValidator;
use CarPark\CarParkModule\Application\DeleteCarPark\Service\DeleteCarParkHandler;
use CarPark\CarParkModule\Application\GetCarPark\Midleware\GetCarParkValidate;
use CarPark\CarParkModule\Application\GetCarPark\Query\GetCarPark;
use CarPark\CarParkModule\Application\GetCarParksList\Query\GetCarParksList;
use CarPark\CarParkModule\Application\GetCarParksList\Service\GetCarParksListHandler;
use CarPark\CarParkModule\Application\GetCarsList\Query\GetCarsList;
use CarPark\CarParkModule\Application\GetCarsList\Service\GetCarsListHandler;
use CarPark\CommonModule\JWT\Middleware\JwtVerifyUser;
use CarPark\CommonModule\UI\Response\Response;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Middleware\CarParkValidator;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Middleware\CarsValidator;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Services\CreateOrUpdateCarParkHandler;
use CarPark\UserModule\Application\DeleteCarPark\Command\DeleteCarPark;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class CarParkController
{
    use Response;

    /**
     * @var CommandBusInterface
     */
    private $bus;

    /**
     * CarParkController constructor.
     * @param CommandBusInterface $bus
     */
    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createCarPark(Request $request): JsonResponse
    {
        $this->bus->addHandler(CreateOrUpdateCarPark::class, CreateOrUpdateCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            CreateOrUpdateCarPark::class,
            array_merge($request->all(), ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, CarParkValidator::class, CarsValidator::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCarPark(Request $request): JsonResponse
    {
        $this->bus->addHandler(DeleteCarPark::class, DeleteCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            DeleteCarParkHandler::class,
            array_merge($request->all(), ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, DeleteCarParkValidator::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCarParksList(Request $request): JsonResponse
    {
        $this->bus->addHandler(GetCarParksList::class, GetCarParksListHandler::class);
        $resultHandler = $this->bus->dispatch(
            GetCarParksListHandler::class,
            ["jwt" => $request->bearerToken()],
            [JwtVerifyUser::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCarsList(Request $request): JsonResponse
    {
        $this->bus->addHandler(GetCarsList::class, GetCarsListHandler::class);
        $resultHandler = $this->bus->dispatch(
            GetCarsListHandler::class,
            ["jwt" => $request->bearerToken()],
            [JwtVerifyUser::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCarPark(Request $request): JsonResponse
    {
        $this->bus->addHandler(GetCarPark::class, GetCarParksListHandler::class);
        $resultHandler = $this->bus->dispatch(
            GetCarPark::class,
            array_merge($request->all(),  ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, GetCarParkValidate::class]
        );

        return $this->getResponse($resultHandler);
    }
}
