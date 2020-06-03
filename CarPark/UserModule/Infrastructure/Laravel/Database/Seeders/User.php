<?php


namespace CarPark\UserModule\Infrastructure\Laravel\Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\User as UserModal;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\Role as RoleModal;
use Illuminate\Support\Str;

class User extends Seeder
{
    public function run(): void
    {
        $roleManager = RoleModal::create([
            "name" => "MANAGER"
        ]);
        $roleManager->save();

        $userManager = UserModal::create([
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password_manager', [
                "round" => 12
            ])
        ]);
        $userManager->save();
        $userManager->roles()->attach($roleManager);

        $roleDriver = RoleModal::create([
            "name" => "DRIVER"
        ]);
        $roleManager->save();

        $userDriver = UserModal::create([
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password_driver', [
                "round" => 12
            ])
        ]);
        $userDriver->save();
        $userDriver->roles()->attach($roleDriver);
    }
}
