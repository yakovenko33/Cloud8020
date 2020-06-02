<?php


namespace CarPark\UserModule\UI\Controllers;


use App\Http\Controllers\Controller;
use CarPark\CommonModule\UI\Response\Response;
use CarPark\UserModule\Application\SingIn\Middleware\SingInValidator;
use CarPark\UserModule\Application\SingIn\Query\SingIn;
use CarPark\UserModule\Application\SingIn\Service\SingInHandler;
use CarPark\UserModule\Application\SingUp\Command\SingUp;
use CarPark\UserModule\Application\SingUp\Middleware\SingUpValidator;
use CarPark\UserModule\Application\SingUp\Service\SingUpHandler;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Joselfonseca\LaravelTactician\CommandBusInterface;

class UserController extends Controller
{
    use Response;

    /**
     * @var CommandBusInterface
     */
    private $bus;

    /**
     * UserController constructor.
     * @param CommandBusInterface $bus
     */
    public function __construct(CommandBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @return JsonResponse
     */
    public function test(): JsonResponse
    {
        return \response()->json(["data" => "not permissions"], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function singUp(Request $request): JsonResponse
    {
        $this->bus->addHandler(SingUp::class, SingUpHandler::class);
        $resultHandler = $this->bus->dispatch(
            SingUp::class,
            $request->all(),
            [SingUpValidator::class]
        );

        return $this->getResponse($resultHandler);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function singIn(Request $request): JsonResponse
    {
        $this->bus->addHandler(SingIn::class, SingInHandler::class);
        $resultHandler = $this->bus->dispatch(
            SingIn::class,
            $request->all(),
            [SingInValidator::class]
        );

        return $this->getResponse($resultHandler);
    }
}
