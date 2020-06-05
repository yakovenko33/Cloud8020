<?php


namespace CarPark\UserModule\Application\SingUp\Service;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Bus\JWT\JwtDecorator;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SingUpHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * SingUpHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        UserRepositoryInterface $userRepository
    ) {
        $this->resultHandler = $resultHandler;
        $this->userRepository = $userRepository;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @return ResultHandlerInterface
     */
    public function handle(CommandQueryInterface $commandQuery): ResultHandlerInterface
    {
        try {
            $user = $this->userRepository->insertUser($commandQuery);
            if (empty($user)) {
                throw new ProblemWithDatabase();
            }

           $this->resultHandler
               ->setResult(["jwt_token" => JwtDecorator::createToken(["id" => $user->id])])
               ->setStatusCode(201);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        }

        return $this->resultHandler;
    }
}
