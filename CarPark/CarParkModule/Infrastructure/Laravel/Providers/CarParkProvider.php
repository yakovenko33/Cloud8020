<?php


namespace CarPark\CarParkModule\Infrastructure\Laravel\Providers;


use CarPark\CarParkModule\Infrastructure\Repositories\CarParkRepository;
use CarPark\CarParkModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class CarParkProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    public $singletons = [
        CarParkRepositoryInterface::class => CarParkRepository::class
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../../UI/Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../../Infrastructure/Migrations');
    }
}
