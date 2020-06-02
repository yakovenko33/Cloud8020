<?php


namespace CarPark\UserModule\UI\Controllers;


use App\Http\Controllers\Controller;
use CarPark\CommonModule\UI\Response\Response;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarParksValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware\CarsValidator;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Services\CreateOrUpdateCarParkHandler;
use Illuminate\Http\Request;
use Joselfonseca\LaravelTactician\CommandBusInterface;

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

    public function createCarPark(Request $request)
    {
        $this->bus->addHandler(CreateOrUpdateCarPark::class, CreateOrUpdateCarParkHandler::class);
        $resultHandler = $this->bus->dispatch(
            CreateOrUpdateCarPark::class,
            $request->all(),
            [CarParksValidator::class, CarsValidator::class] //JwtVerifyUser::class,
        );

        return $this->getResponse($resultHandler);
    }
}
