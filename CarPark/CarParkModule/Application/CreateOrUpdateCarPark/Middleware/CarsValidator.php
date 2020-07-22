<?php


namespace CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Middleware;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\CarParkModule\Application\CreateOrUpdateCarPark\Command\CreateOrUpdateCarPark;
use Illuminate\Contracts\Validation\Validator as Result;
use Illuminate\Support\Facades\Validator;
use League\Tactician\Middleware;

class CarsValidator implements Middleware
{
    /**
     * @var array
     */
    private $error = [];

    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * CarsValidator constructor.
     * @param ResultHandlerInterface $resultHandler
     */
    public function __construct(ResultHandlerInterface $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    /**
     * @param $command
     * @param callable $next
     * @return ResultHandlerInterface
     */
    public function execute($command, callable $next)
    {
        return  $this->validate($command) ? $next($command) : $this->resultHandler;
    }

    /**
     * @param CreateOrUpdateCarPark $command
     * @return bool
     */
    public function validate(CreateOrUpdateCarPark $command): bool
    {
        $this->executeValidate($command);
        if (!empty($this->error)) {
            $this->resultHandler->setErrors(["cars_errors" => $this->error])->setStatusCode(422);

            return false;
        }

        return true;
    }

    /**
     * @param CreateOrUpdateCarPark $command
     */
    private function executeValidate(CreateOrUpdateCarPark $command): void
    {
        foreach($command->getCars() as $index => $car) {
            $validator = $this->make($car->toArray());
            if ($validator->fails()) {
                $this->error[$index] = $validator->errors()->getMessages();
            }
        }
    }

    /**
     * @param array $data
     * @return Result
     */
    private function make(array $data = [])
    {
        return Validator::make($data, $this->getRules(),  $this->getMessagesValidator());
    }

    /**
     * @return array
     */
    public function getRules(): array
    {
        return [
            "id" => "nullable|integer|bail|exists:cars,id",
            "number_car" => "required|string|max:15",
            "name_driver" => "required|string|max:75"
        ];
    }

    /**
     * @return array
     */
    public function getMessagesValidator(): array
    {
        return [
            "id.integer" => "Id должно быть целочисельным",
            "id.exists" => "Такой машины не существует",
            "number_car.required" => "Номер машины обязательный",
            "number_car.max" => "Длина номера машины превышает :max символов",
            "name_driver.required" => "Имя водителя обязательное",
            "name_driver.max" => "Длина имени водителя превышает :max символов",
        ];
    }
}
