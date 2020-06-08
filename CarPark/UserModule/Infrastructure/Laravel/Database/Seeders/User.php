<?php


namespace CarPark\UserModule\Infrastructure\Laravel\Database\Seeders;


use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User as UserModal;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Role as RoleModal;

class User extends Seeder
{
    public function run(): void
    {
        $this->createManager();
        $this->createDriver();
    }

    /**
     * @return array
     */
    private function initPermissions(): array
    {
        $createUpdateCarPark = Permission::create([
            'name' => "create-update-car-park"
        ]);
        $createUpdateCarPark->save();

        $deleteCar = Permission::create([
            'name' => "delete-car"
        ]);
        $deleteCar->save();

        $deleteCarPark = Permission::create([
            'name' => "delete-car-park"
        ]);
        $deleteCar->save();

        return [
            $createUpdateCarPark->id,
            $deleteCar->id,
            $deleteCarPark->id
        ];
    }

    private function createManager(): void
    {
        $roleManager = RoleModal::create([
            "name" => "MANAGER"
        ]);
        $roleManager->save();

        $roleManager->permissions()->attach($this->initPermissions());

        $userManager = UserModal::create([
            'email' => "test_manager@gmail.com",
            'password' => Hash::make('password_manager', [
                "round" => 12
            ])
        ]);
        $userManager->save();
        $userManager->roles()->attach($roleManager);
    }

    private function createDriver(): void
    {
        $roleDriver = RoleModal::create([
            "name" => "DRIVER"
        ]);
        $roleDriver->save();

        $userDriver = UserModal::create([
            'email' => "test_driver@gmail.com",
            'password' => Hash::make('password_driver', [
                "round" => 12
            ])
        ]);
        $userDriver->save();
        $userDriver->roles()->attach($roleDriver);
    }
}
