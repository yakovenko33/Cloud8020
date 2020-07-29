<?php


namespace CarPark\CarParkModule\Application\GetCarPark\Service;


use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;
use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CommonModule\Exception\ProblemWithDatabase;
use CarPark\CarParkModule\Application\GetCarPark\Exception\BadDataException;
use CarPark\UserModule\Application\SingIn\Exceptions\VerifyUserException;
use CarPark\CarParkModule\Infrastructure\Interfaces\CarParkRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class GetCarParkHandler
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * @var CarParkRepositoryInterface
     */
    private $repository;

    /**
     * GetCarHandler constructor.
     * @param ResultHandlerInterface $resultHandler
     * @param CarParkRepositoryInterface $repository
     */
    public function __construct(
        ResultHandlerInterface $resultHandler,
        CarParkRepositoryInterface $repository
    ) {
        $this->resultHandler = $resultHandler;
        $this->repository = $repository;
    }

    /**
     * @param VerifyCommandQuery $query
     * @return ResultHandlerInterface
     */
    public function handle(VerifyCommandQuery $query): ResultHandlerInterface
    {
        try {
            $this->checkData($query);
            $this->setCarPark($query);
            $this->setCar($query);

        } catch(ProblemWithDatabase $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode();
        } catch (BadDataException $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode(422);
        } catch (VerifyUserException $e) {
            $this->resultHandler->setErrors($e->getError())->setStatusCode(403);
        }

        return $this->resultHandler;
    }

    /**
     * @param VerifyCommandQuery $query
     * @throws BadDataException
     */
    private function checkData(VerifyCommandQuery $query): void
    {
        if ((empty($query->getCarParkId()) && empty($query->getCarId())) ||
            (!empty($query->getCarParkId()) && !empty($query->getCarId()))
        ) {
            throw new BadDataException();
        }
    }

    /**
     * @param VerifyCommandQuery $query
     * @throws ProblemWithDatabase
     * @throws VerifyUserException
     */
    private function setCarPark(VerifyCommandQuery $query): void
    {
        if (!empty($query->getCarParkId())) {
            if (!$query->getUser()->hasPermissions("get-edit-car-park")) {
                throw new VerifyUserException();
            }

            $this->setResult(
                "car_park",
                $this->repository->getCarParkById($query->getCarParkId())
            );
        }
    }

    /**
     * @param VerifyCommandQuery $query
     * @throws ProblemWithDatabase
     * @throws VerifyUserException
     */
    private function setCar(VerifyCommandQuery $query): void
    {
        if (!empty($query->getCarId())) {
            if (!$query->getUser()->hasPermissions("get-edit-car")) {
                throw new VerifyUserException();
            }

            $this->setResult(
                "car",
                $this->repository->getCarById($query->getCarId())
            );
        }
    }

    /**
     * @param string $dataName
     * @param Model $result
     * @throws ProblemWithDatabase
     */
    private function setResult(string $dataName, Model $result): void
    {
        if (empty($result)) {
            throw new ProblemWithDatabase();
        }

        $this->resultHandler->setResult([
            $dataName => $result
        ])->setStatusCode(200);
    }
}
