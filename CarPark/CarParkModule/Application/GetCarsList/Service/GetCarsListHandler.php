<?php


namespace CarPark\CarParkModule\Application\GetCarsList\Service;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\CarParkModule\Application\GetCarsList\Query\GetCarsList;
use CarPark\CarParkModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use CarPark\CarParkModule\Infrastructure\Laravel\Database\Modals\Car;
use Illuminate\Support\Facades\Log;

class GetCarsListHandler
{
    /**
     * @var
     */
    private $repository;

    /**
     * @var
     */
    private $resultHandler;

    /**
     * GetCarsListHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param CarParkRepositoryInterface $repository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        CarParkRepositoryInterface $repository
    ) {
        $this->repository = $repository;
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param GetCarsList $carsList
     * @return ResultHandlerInterface
     */
    public function handle(GetCarsList $carsList): ResultHandlerInterface
    {
        try {
            $result = ($carsList->getUser()->hasRoles("DRIVER"))
                ? $this->repository->getCarsList($carsList->getUser()->id)
                : $this->repository->getCarsList();

            if (empty($result)) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler
                ->setResult(["cars" => $result->toArray()])
                ->setStatusCode(200);

        } catch (ProblemWithDatabase $e) {
            $this->resultHandler
                ->setErrors($e->getError())
                ->getStatusCode();
        }

        return $this->resultHandler;
    }
}
