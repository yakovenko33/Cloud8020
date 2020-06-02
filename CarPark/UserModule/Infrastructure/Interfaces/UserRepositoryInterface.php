<?php


namespace CarPark\UserModule\Infrastructure\Interfaces;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\UserModule\Infrastructure\Modals\User;

interface UserRepositoryInterface
{
    /**
     * @param CommandQueryInterface $commandQuery
     * @return User|null
     */
    public function addUser(CommandQueryInterface $commandQuery): ?User;

    /**
     * @param string $email
     * @return User|null
     */
    public function getByEmail(string $email): ?User;
}
