<?php


namespace CarPark\CarParkModule\Infrastructure\Laravel\Providers;


use Illuminate\Support\ServiceProvider;

class CarParkProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../../UI/Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../../Infrastructure/Migrations');
    }
}
