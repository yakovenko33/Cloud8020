<?php


namespace CarPark\UserModule\Application\DeleteCarPark\Command;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;
use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;

class DeleteCarPark extends VerifyCommandQuery implements CommandQueryInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * DeleteCarPark constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data["jwt"]);
        $this->id = $data["id"];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "id" => $this->id
        ];
    }
}
