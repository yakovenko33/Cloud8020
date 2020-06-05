<?php


namespace CarPark\UserModule\Infrastructure\Repositories;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Role;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User;
use \Illuminate\Support\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param CommandQueryInterface $commandQuery
     * @return User|null
     */
    public function insertUser(CommandQueryInterface $commandQuery): ?User
    {
        try {
            $result = User::create([
                "email" => $commandQuery->getEmail(),
                "password" =>  Hash::make($commandQuery->getPassword(), [
                    "round" => 12
                ])
            ]);
            $result->save();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param string $email
     * @return User
     */
    public function getByEmail(string $email): ?User
    {
        try {
            $result = User::where("email", $email)->first();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return Collection|null
     */
    public function getRolesByUserId(int $id): ?Collection
    {
        try {
            $result = DB::table("users_roles as u_r")
                ->select('name')
                ->join("roles as r", "u_r.role_id", "=", "r.id")
                ->where('u_r.user_id', $id)
                ->get();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function getById(int $id): ?User
    {
        try {
            $result = User::where("id", $id)->first();
        } catch (QueryException $e) {
            Log::debug($e->getMessage() . $e->getTraceAsString());
            $result = null;
        }

        return $result;
    }
}
