<?php


namespace CarPark\UserModule\Application\CreateOrUpdateCarPark\Middleware;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;
use CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO\CarPark;
use Illuminate\Contracts\Validation\Validator as Result;
use Illuminate\Support\Facades\Validator;
use League\Tactician\Middleware;

class CarParkValidator implements Middleware
{
    /**
     * @var ResultHandlerInterface
     */
    private $resultHandler;

    /**
     * CarParkValidator constructor.
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
        if ($command->getCarPark()) {
            return $this->validate($command->getCarPark()) ? $next($command) : $this->resultHandler;
        }

        return $next($command);
    }

    /**
     * @param CarPark $dto
     * @return bool
     */
    private function validate(CarPark $dto): bool
    {
        $validator = $this->make($dto->toArray());
        if($validator->fails()) {
            $this->resultHandler
                ->setErrors($validator->errors()->getMessages())
                ->setStatusCode(422);
            return false;
        }

        return true;
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
    private function getRules(): array
    {
        return [
            "id" => "nullable|integer|bail|exists:car_parks,id",
            "title" => "required|string|max:50",
            "address" => "required|string|max:80",
            "time_work" => "required|string|max:100"
        ];
    }

    /**
     * @return array
     */
    private function getMessagesValidator(): array
    {
        return [
            "id.integer" => "Id должно быть целочисельным",
            "id.exists" => "Такого автопарка не существует",
            "title.required" => "Название автопарка обязательное поле",
            "title.max" => "Длина названия автопарка превышает :max символов",
            "address.required" => "Адресс автопарка обязательный",
            "address.max" => "Длина адресса автопарка превышает :max символов",
            "time_work.required" => "Время работы обязательное",
            "time_work.max" => "Длина времени работы превышает :max символов"
        ];
    }
}
