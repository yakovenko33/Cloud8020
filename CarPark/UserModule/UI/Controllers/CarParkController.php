<?php


namespace CarPark\UserModule\UI\Controllers;


use App\Http\Controllers\Controller;
use CarPark\CommonModule\JWT\Middleware\JwtVerifyUser;
use CarPark\CommonModule\UI\Response\Response;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarParksValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarsValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Services\CreateOrUpdateCarParkHandler;
use CarPark\UserModule\Application\DeleteCarPark\Command\DeleteCarPark;
use CarPark\UserModule\Application\DeleteCarPark\Service\DeleteCarParkHandler;
use Illuminate\Http\Request;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function createCarPark(Request $request): JsonResponse
    {
        $this->bus->addHandler(CreateOrUpdateCarPark::class, CreateOrUpdateCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            CreateOrUpdateCarPark::class,
            $request->all(),
            [CarParksValidator::class, CarsValidator::class, JwtVerifyUser::class] //JwtVerifyUser::class,
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
            $request->all(),
            [ JwtVerifyUser::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteCar(Request $request): JsonResponse
    {
        $this->bus->addHandler(DeleteCarPark::class, DeleteCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            DeleteCarPark::class,
            $request->all(),
            [ JwtVerifyUser::class]
        );

        return $this->getResponse($resultHandler);
    }
}
