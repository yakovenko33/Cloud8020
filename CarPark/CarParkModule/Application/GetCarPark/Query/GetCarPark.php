<?php


namespace CarPark\CarParkModule\Application\GetCarPark\Query;


use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;

class GetCarPark extends VerifyCommandQuery
{
    /**
     * @var mixed
     */
    private $carParkId;

    /**
     * @var mixed
     */
    private $carId;

    /**
     * GetCar constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data["jwt"]);

        $this->carParkId = array_key_exists("car_park_id", $data) ? $data["car_park_id"] : null;
        $this->carId = array_key_exists("car_id", $data) ? $data["car_id"] : null;
    }

    /**
     * @return mixed
     */
    public function getCarParkId()
    {
        return $this->carParkId;
    }

    /**
     * @return mixed
     */
    public function getCarId()
    {
        return $this->carId;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "car_park_id" => $this->carParkId,
            "car_id" => $this->carId
        ];
    }
}
