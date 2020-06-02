<?php


namespace CarPark\UserModule\Application\SingIn\Service;




use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Bus\JWT\JwtDecorator;
use CarPark\UserModule\Application\SingIn\Exceptions\VerifyUserException;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class SingInHandler
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
     * SingInHandler constructor.
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
            $user = $this->userRepository->getByEmail($commandQuery->getEmail());
            if (empty($user)) {
                throw new VerifyUserException();
            }

            $this->checkPassword($commandQuery->getPassword(), $user->password);
            $this->resultHandler->setResult(["jwt_token" => JwtDecorator::createToken(["id" => $user->id])]);
        } catch (VerifyUserException $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        }

        return $this->resultHandler;
    }

    /**
     * @param string $plainPassword
     * @param string $hashPassword
     * @throws VerifyUserException
     */
    private function checkPassword(string $plainPassword, string $hashPassword): void
    {
        if (!Hash::check($plainPassword, $hashPassword)) {
            throw new VerifyUserException();
        }
    }
}
