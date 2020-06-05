<?php


namespace CarPark\UserModule\Infrastructure\Interfaces;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * @param CommandQueryInterface $commandQuery
     * @return User|null
     */
    public function insertUser(CommandQueryInterface $commandQuery): ?User;

    /**
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User;

    /**
     * @param int $id
     * @return Collection|null
     */
    public function getRolesByUserId(int $id): ?Collection;
}
