<?php

namespace database\seeds;

use Illuminate\Database\Seeder;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Permission;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Role as RoleModal;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User as UserModal;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Seeder
{
    /**
     * @var array
     */
    private $managerPermissions = [
        "create-update-car-park",
        "delete-car",
        "delete-car-park",
        "get-edit-car-park",
        "get-edit-car"
    ];

    public function run(): void
    {
        $this->createManager();
        $this->createDriver();
    }

    private function createManager(): void
    {
        $roleManager = $this->createRole("MANAGER", $this->managerPermissions());

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
        $roleDriver = $this->createRole("DRIVER", $this->driverPermissions());

        $userDriver = UserModal::create([
            'email' => "test_driver@gmail.com",
            'password' => Hash::make('password_driver', [
                "round" => 12
            ])
        ]);
        $userDriver->save();
        $userDriver->roles()->attach($roleDriver);
    }

    /**
     * @param string $nameRole
     * @param array $permissions
     * @return RoleModal
     */
    private function createRole(string $nameRole, array $permissions): RoleModal
    {
        $role = RoleModal::create([
            "name" => $nameRole
        ]);

        $role->save();
        $role->permissions()->attach($permissions);

        return $role;
    }

    /**
     * @return array
     */
    private function managerPermissions(): array
    {
        $permissions = [];
        foreach($this->managerPermissions as $permission) {
            $permissions[] = $this->addPermission($permission);
        }

        return $permissions;
    }

    /**
     * @return array
     */
    private function driverPermissions(): array
    {
        $permissions[] = $this->addPermission("get-edit-car");

        return $permissions;
    }

    /**
     * @param string $namePermission
     * @return int
     */
    private function addPermission(string $namePermission): int
    {
        $permission = Permission::create([
            'name' => $namePermission
        ]);
        $permission->save();

        return $permission->id;
    }
}
