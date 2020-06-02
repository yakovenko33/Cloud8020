<?php


namespace CarPark\UserModule\Infrastructure\Repositories;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use CarPark\UserModule\Infrastructure\Modals\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    public function addUser(CommandQueryInterface $commandQuery): ?User
    {
        try {
            $user = User::create([
                "email" => $commandQuery->getEmail(),
                "password" =>  Hash::make($commandQuery->getPassword(), [
                    "round" => 12
                ])
            ]);
            $user->save();
        } catch (QueryException $e) {
            Log::log($e->getMessage(), $e->getTraceAsString());
            $user = null;
        }

        return $user;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): ?User
    {
        try {
            $user = User::where("email", $email)->first();
        } catch (QueryException $e) {
            Log::log($e->getMessage(), $e->getTraceAsString());
            $user = null;
        }

        return $user;
    }
}
