<?php


namespace CarPark\UserModule\Infrastructure\Providers;


use CarPark\CommonModule\Bus\Handler\ResultHandler;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use CarPark\UserModule\Infrastructure\Repositories\CarParkRepository;
use CarPark\UserModule\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        UserRepositoryInterface::class => UserRepository::class,
        ResultHandlerInterface::class => ResultHandler::class,
        CarParkRepositoryInterface::class => CarParkRepository::class
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../UI/Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../Infrastructure/Migrations');
    }
}
