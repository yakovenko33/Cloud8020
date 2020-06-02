<?php


namespace CarPark\UserModule\Application\DeleteCarPark\Service;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\UserModule\Infrastructure\Interfaces\CarParkRepositoryInterface;

class DeleteCarParkHandler
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
     * DeleteCarParkHandler constructor.
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
        if ($commandQuery->getUser()->hasRole("MANAGER")) {
            $this->deleteCarPark($commandQuery);
        } else {
            $this->resultHandler
                ->setErrors(["authorization" => ["User authorization failed."]])
                ->setStatusCode(403);
        }

        return $this->resultHandler;
    }

    /**
     * @param CommandQueryInterface $command
     */
    private function deleteCarPark(CommandQueryInterface $command): void
    {
        try {
            if (empty($this->carParkRepository->deleteCarParkById($command->getid()))) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setStatusCode(202);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError());
        }
    }
}
