<?php


namespace CarPark\CarParkModule\Application\DeleteCarPark\Service;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\AccessControlException;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\CarParkModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use Illuminate\Support\Facades\Log;

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
        try {
            $this->checkAccess($commandQuery);
            if (empty($this->carParkRepository->deleteCarParkById($commandQuery->getId()))) {
                throw new ProblemWithDatabase();
            }

            $this->resultHandler->setStatusCode(202);
        } catch (ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        } catch (AccessControlException $e) {
            $this->resultHandler
                ->setErrors($e->getError())
                ->setStatusCode(403);
        }

        return $this->resultHandler;
    }

    /**
     * @param CommandQueryInterface $commandQuery
     * @throws AccessControlException
     */
    private function checkAccess(CommandQueryInterface $commandQuery): void
    {
        if (!$commandQuery->getUser()->hasPermissions("delete-car-park")) {
            throw new AccessControlException();
        }
    }
}
