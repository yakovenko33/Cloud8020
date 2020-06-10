<?php


namespace Tests\UserModule\Helpers\DataClasses;


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
     * @param string $numberCar
     * @param string $nameDriver
     */
    public function __construct(string $numberCar, string $nameDriver)
    {
        $this->numberCar = $numberCar;
        $this->nameDriver = $nameDriver;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $numberCar
     * @return $this
     */
    public function setNumberCar(string $numberCar): self
    {
        $this->numberCar = $numberCar;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumberCar(): string
    {
        return $this->numberCar;
    }

    /**
     * @param string $nameDriver
     * @return $this
     */
    public function setNameDriver(string $nameDriver): self
    {
        $this->nameDriver = $nameDriver;

        return $this;
    }

    /**
     * @return string
     */
    public function getNameDriver(): string
    {
        return $this->nameDriver;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->id,
            "number_car" => $this->numberCar,
            "name_driver" => $this->nameDriver
        ];
    }
}
