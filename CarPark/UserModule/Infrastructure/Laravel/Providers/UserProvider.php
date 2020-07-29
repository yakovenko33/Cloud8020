<?php


namespace CarPark\UserModule\Infrastructure\Laravel\Providers;


use CarPark\CommonModule\Bus\Handler\ResultHandler;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use CarPark\UserModule\Infrastructure\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * @var array
     */
    public $singletons = [
        UserRepositoryInterface::class => UserRepository::class,
        ResultHandlerInterface::class => ResultHandler::class
    ];

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../../UI/Routes/api.php');

        $this->loadMigrationsFrom(__DIR__ . '/../../../Infrastructure/Migrations');
    }
}
