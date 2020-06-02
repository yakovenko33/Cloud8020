<?php


namespace CarPark\CommonModule\JWT\Middleware;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Bus\JWT\JwtDecorator;
use CarPark\UserModule\Infrastructure\Modals\User;
use CarPark\UserModule\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use League\Tactician\Middleware;

class JwtVerifyUser implements Middleware
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;


    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * JwtVerifyUser constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param UserRepository $userRepository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        UserRepository $userRepository
    ) {
        $this->resultHandler = $resultHandler;
        $this->userRepository = $userRepository;
    }

    /**
     * @param object $command
     * @param callable $next
     * @return ResultHandlerInterface|mixed
     */
    public function execute($command, callable $next)
    {
        try {
            $decoded = JwtDecorator::getDataByToken($command->getJwtToken());
            $command->setUser($this->userRepository->getById($decoded->data->id));
        } catch (\Exception $e) {
            $this->resultHandler
                ->setErrors(["authorization" => ["User authorization failed."]])
                ->setStatusCode(403);

            return $this->resultHandler;
        }

        return $next($command);
    }
}
