<?php


namespace CarPark\UserModule\Application\CreateOrUpdateCarPark\DTO;


class CarPark
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $timeWork;

    /**
     * CarPark constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = array_key_exists("id", $data) ? $data["id"] : null;
        $this->title = $data["title"];
        $this->address = $data["address"];
        $this->timeWork = $data["time_work"];
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getTimeWork(): string
    {
        return $this->timeWork;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => "nullable|int",
            "title" => $this->title,
            "address" => $this->address,
            "time_work" => $this->timeWork
        ];
    }
}
