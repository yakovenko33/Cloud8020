<?php

namespace CarPark\CommonModule\Bus\Command;


use CarPark\UserModule\Infrastructure\Modals\User;

class VerifyCommandQuery
{
    /**
     * @var string
     */
    protected $jwtToken;

    /**
     * @var
     */
    protected $user;

    /**
     * VerifyCommandQuery constructor.
     * @param string $jwtToken
     */
    public function __construct(string $jwtToken)
    {
        $this->jwtToken = $jwtToken;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getJwtToken(): string
    {
        return $this->jwtToken;
    }
}
