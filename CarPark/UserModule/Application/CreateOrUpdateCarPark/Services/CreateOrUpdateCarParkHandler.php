<?php


namespace CarPark\UserModule\Application\CreateOrUpdateCarPark\Services;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark as CarsParkDto;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CreateOrUpdateCarParkHandler
{
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
     * @param CarParkRepositoryInterface $carParkRepository
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(
        CarParkRepositoryInterface $carParkRepository,
        ResultHandlerInterface $resultHandler
    ) {
        $this->carParkRepository = $carParkRepository;
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @return ResultHandlerInterface
     */
    public function handle(CommandQueryInterface $commandQuery): ResultHandlerInterface
    {
        try {
            DB::beginTransaction();

            $carPark = null;
            if ($commandQuery->getUser()->hasPermissions("create-update-car-park")) {
                $carPark = $this->insertOrUpdateCarPark($commandQuery->getCarPark());
            }

            $this->insertOrUpdateCar($commandQuery, $carPark);
            $this->resultHandler->setStatusCode(201);

            DB::commit();
        } catch (ProblemWithDatabase $e) {
            DB::rollBack();
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        }

        return $this->resultHandler;
    }

    /**
     * @param CarsParkDto $dto
     * @return CarPark
     * @throws ProblemWithDatabase
     */
    private function insertOrUpdateCarPark(CarsParkDto $dto): CarPark
    {
        $carPark = (empty($dto->getId()))
            ? $this->carParkRepository->insertCarPark($dto)
            : $this->carParkRepository->updateCarParkById($dto);
        $this->assetEmpty($carPark);

        return $carPark;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @param CarPark|null $carPark
     * @throws ProblemWithDatabase
     */
    private function insertOrUpdateCar(CommandQueryInterface $commandQuery, CarPark $carPark = null): void
    {
        $addedCars = [];
        foreach($commandQuery->getCars() as $car) {
            if (empty($car->getId())) {
                $result = $this->carParkRepository->insertCar($car, $commandQuery->getUser()->id);
                $this->assetEmpty($result);
                $addedCars[] = $result->id;
            } else {
                $result = $this->carParkRepository->updateCarById($car, $commandQuery->getUser()->id);
                $this->assetEmpty($result);
            }
        }

        if ($carPark) {
            $carPark->cars()->attach($addedCars);
        }
    }

    /**
     * @param Model|null $entity
     * @throws ProblemWithDatabase
     */
    private function assetEmpty(Model $entity = null): void
    {
        if (empty($entity)) {
            throw new ProblemWithDatabase();
        }
    }
}
