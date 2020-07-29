<?php


namespace CarPark\CarParkModule\Application\DeleteCar\Service;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\AccessControlException;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\CarParkModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use Illuminate\Support\Facades\Log;

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
        Log::debug("Delete car " . $commandQuery->getId());
        try {
            $this->checkAccess($commandQuery);
            if (empty($this->carParkRepository->deleteCarById($commandQuery->getId()))) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setStatusCode(202);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        } catch (AccessControlException $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode(403);
        }

        return $this->resultHandler;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @throws AccessControlException
     */
    private function checkAccess(CommandQueryInterface $commandQuery): void
    {
        if (!$commandQuery->getUser()->hasPermissions("delete-car")) {
            throw new AccessControlException();
        }
    }
}
