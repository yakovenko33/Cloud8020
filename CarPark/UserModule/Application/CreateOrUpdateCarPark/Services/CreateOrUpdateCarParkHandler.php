<?php


namespace CarPark\UserModule\Application\CreateOrUpdateCarPark\Services;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark as CarsParkDto;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\UserModule\Infrastructure\Interfaces\UserRepositoryInterface;
use CarPark\UserModule\Infrastructure\Modals\CarPark;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CreateOrUpdateCarParkHandler
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var CarParkRepositoryInterface
     */
    private $carParkRepository;

    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * CreateOrUpdateCarParkHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param CarParkRepositoryInterface $carParkRepository
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CarParkRepositoryInterface $carParkRepository,
        ResultHandlerInterface $resultHandler
    ) {
        $this->userRepository = $userRepository;
        $this->carParkRepository = $carParkRepository;
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     */
    public function handle(CommandQueryInterface $commandQuery): void
    {
        try {
            DB::beginTransaction();

            $carsPark = $this->insertOrUpdateCarsPark($commandQuery->getCarsPark());
            $this->insertOrUpdateCar($commandQuery, $carsPark);
            $this->resultHandler->setStatusCode(201);

            DB::commit();
        } catch (ProblemWithDatabase $e) {
            DB::rollBack();
            $this->resultHandler->setErrors($e->getError());
        }

        return $this->resultHandler;
    }

    /**
     * @param CarsParkDto $dto
     * @return CarPark
     * @throws ProblemWithDatabase
     */
    private function insertOrUpdateCarsPark(CarsParkDto $dto): CarPark
    {
        $carsPark = (empty($dto->getId()))
            ? $this->carParkRepository->insertCarsPark($dto)
            : $this->carParkRepository->updateCarsParkById($dto);
        $this->assetEmpty($carsPark);

        return $carsPark;
    }

    /**
     * @param CreateOrUpdateCarPark $commandQuery
     * @param CarPark $carsPark
     * @throws ProblemWithDatabase
     */
    private function insertOrUpdateCar(CreateOrUpdateCarPark $commandQuery, CarPark $carsPark): void
    {
        $addedCars = [];
        foreach($commandQuery->getCars() as $car) {
            if (empty($car->getId())) {
                $result = $this->carParkRepository->addCar($car);
                $this->assetEmpty($result);
                $addedCars[] = $result->id;
            } else {
                $result = $this->carParkRepository->updateCarById($car);
                $this->assetEmpty($result);
            }
        }

        $carsPark->cars()->attach($addedCars);
    }

    /**
     * @param Model $entity
     * @throws ProblemWithDatabase
     */
    private function assetEmpty(Model $entity): void
    {
        if (empty($entity)) {
            throw new ProblemWithDatabase();
        }
    }
}
