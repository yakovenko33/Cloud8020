<?php


namespace CarPark\UserModule\UI\Controllers;


use App\Http\Controllers\Controller;
use CarPark\CommonModule\JWT\Middleware\JwtVerifyUser;
use CarPark\CommonModule\UI\Response\Response;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarParkValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarsValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Services\CreateOrUpdateCarParkHandler;
use CarPark\UserModule\Application\DeleteCar\Middleware\DeleteCarValidator;
use CarPark\UserModule\Application\DeleteCar\Service\DeleteCarHandler;
use CarPark\UserModule\Application\DeleteCarPark\Command\DeleteCarPark;
use CarPark\UserModule\Application\DeleteCarPark\Middleware\DeleteCarParkValidator;
use CarPark\UserModule\Application\DeleteCarPark\Service\DeleteCarParkHandler;
use CarPark\UserModule\Application\GetCarPark\Midleware\GetCarParkValidate;
use CarPark\UserModule\Application\GetCarPark\Query\GetCarPark;
use CarPark\UserModule\Application\GetCarPark\Service\GetCarParkHandler;
use CarPark\UserModule\Application\GetCarParksList\Query\GetCarParksList;
use CarPark\UserModule\Application\GetCarParksList\Service\GetCarParksListHandler;
use CarPark\UserModule\Application\GetCarsList\Query\GetCarsList;
use CarPark\UserModule\Application\GetCarsList\Service\GetCarsListHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Joselfonseca\LaravelTactician\CommandBusInterface;
use \Illuminate\Http\JsonResponse;

class CarParkController extends Controller
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
            DeleteCarPark::class,
            array_merge($request->all(), ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, DeleteCarParkValidator::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCar(Request $request): JsonResponse
    {
        $this->bus->addHandler(DeleteCarPark::class, DeleteCarHandler::class);
        $resultHandler = $this->bus->dispatch(
            DeleteCarPark::class,
            array_merge($request->all(), ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, DeleteCarValidator::class]
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
            GetCarParksList::class,
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
            GetCarsList::class,
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
        $this->bus->addHandler(GetCarPark::class, GetCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            GetCarPark::class,
            array_merge($request->all(),  ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, GetCarParkValidate::class]
        );

        return $this->getResponse($resultHandler);
    }
}
