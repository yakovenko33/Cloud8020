<?php
declare(strict_types = 1);

namespace CarPark\CarParkModule\Application\CreateOrUpdateCarPark\DTO;


class Car
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $numberCar;

    /**
     * @var string
     */
    private $nameDriver;

    /**
     * Car constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = array_key_exists("id", $data) ? $data["id"] : null;
        $this->numberCar = $data["number_car"];
        $this->nameDriver = $data["name_driver"];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNameDriver(): string
    {
        return $this->nameDriver;
    }

    /**
     * @return string
     */
    public function getNumberCar(): string
    {
        return $this->numberCar;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->id, //
            "number_car" => $this->numberCar,
            "name_driver" => $this->nameDriver
        ];
    }
}
