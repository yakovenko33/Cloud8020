<?php


namespace CarPark\UserModule\Application\DeleteCar\Service;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;

class DeleteCarHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var CarParkRepositoryInterface
     */
    private $carParkRepository;

    /**
     * DeleteCarHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param CarParkRepositoryInterface $carParkRepository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        CarParkRepositoryInterface $carParkRepository
    ) {
        $this->resultHandler = $resultHandler;
        $this->carParkRepository = $carParkRepository;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @return ResultHandlerInterface
     */
    public function handle(CommandQueryInterface $commandQuery): ResultHandlerInterface
    {
        try {
            if (empty($this->carParkRepository->deleteCarById($commandQuery->getId()))) {
                throw new ProblemWithDatabase();
            }
            $this->resultHandler->setStatusCode(202);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError());
        }

        return $this->resultHandler;
    }
}