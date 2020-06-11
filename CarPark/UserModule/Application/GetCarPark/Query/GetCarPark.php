<?php


namespace CarPark\UserModule\Application\GetCarPark\Query;


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

        $this->carParkId = $data["car_park_id"];
        $this->carId = $data["car_id"];
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
