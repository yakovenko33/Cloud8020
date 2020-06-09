<?php


namespace Tests\UserModule\Helpers\DataClasses;


class CarPark
{
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
     * @param string $title
     * @param string $address
     * @param string $timeWork
     */
    public function __construct(string $title, string $address, string $timeWork)
    {
        $this->title= $title;
        $this->address = $address;
        $this->timeWork = $timeWork;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $timeWork
     * @return $this
     */
    public function setTimeWork(string $timeWork): self
    {
        $this->timeWork = $timeWork;

        return $this;
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
            "title" => $this->title,
            "address" => $this->address,
            "time_work" => $this->timeWork
        ];
    }
}
