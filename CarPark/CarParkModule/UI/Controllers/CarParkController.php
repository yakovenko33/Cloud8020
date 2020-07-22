<?php


namespace CarPark\CarParkModule\UI\Controllers;


use CarPark\CommonModule\JWT\Middleware\JwtVerifyUser;
use CarPark\CommonModule\UI\Response\Response;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarParkValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarsValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Services\CreateOrUpdateCarParkHandler;
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
        echo "<pre>";
        var_dump("CarParkController::createCarPark()");
        die;
        $this->bus->addHandler(CreateOrUpdateCarPark::class, CreateOrUpdateCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            CreateOrUpdateCarPark::class,
            array_merge($request->all(), ["jwt" => $request->bearerToken()]),
            [JwtVerifyUser::class, CarParkValidator::class, CarsValidator::class]
        );

        return $this->getResponse($resultHandler);
    }
}
