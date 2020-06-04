<?php


namespace CarPark\UserModule\Application\GetCarParksList\Service;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Application\GetCarParksList\Query\GetCarParksList;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\UserModule\Infrastructure\Laravel\Database\Modals\CarPark;

class GetCarParksListHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var
     */
    private $repository;

    /**
     * GetCarParksListHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param CarParkRepositoryInterface $repository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        CarParkRepositoryInterface $repository
    ){
        $this->repository = $repository;
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param GetCarParksList $query
     * @return ResultHandlerInterface
     */
    public function handle(GetCarParksList $query): ResultHandlerInterface
    {
        try {
            $result = ($query->getUser()->hasRoles("DRIVER"))
                ? $this->repository->getCarParksList($query->getUser()->id)
                : $this->repository->getCarParksList();

            if (empty($result)) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setResult(["car_parks" => $result->toArray()]);
        } catch(ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError());
        }

        return $this->resultHandler;
    }
}
