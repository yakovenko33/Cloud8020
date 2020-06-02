<?php


namespace CarPark\UserModule\Application\SingUp\Command;


use CarPark\CommonModule\Bus\Command\CommandQueryInterface;

class SingUp implements CommandQueryInterface
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * SingUp constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->email = $data['email'];
        $this->password = $data["password"];
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            "email" => $this->email,
            "password" => $this->password
        ];
    }
}
