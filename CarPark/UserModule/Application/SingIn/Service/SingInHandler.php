<?php


namespace CarPark\UserModule\Application\SingIn\Service;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Bus\JWT\JwtDecorator;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Application\SingIn\Exceptions\VerifyUserException;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            $this->assertEmpty($user);

            $this->checkPassword($commandQuery->getPassword(), $user->password);
            $this->resultHandler->setResult([
                "jwt_token" => JwtDecorator::createToken(["id" => $user->id]),
                "roles" =>  $this->getRoles($user->id)
            ])->setStatusCode(200);
        } catch (VerifyUserException $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode(403);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        }

        return $this->resultHandler;
    }

    /**
     * @param int $userId
     * @return Collection
     * @throws ProblemWithDatabase
     */
    private function getRoles(int $userId): Collection
    {
        if (empty($roles = $this->userRepository->getRolesByUserId($userId))) {
            throw new ProblemWithDatabase();
        }

        return $roles;
    }

    /**
     * @param User|null $user
     * @throws VerifyUserException
     */
    private function assertEmpty(User $user = null): void
    {
        if (empty($user)) {
            throw new VerifyUserException();
        }
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
