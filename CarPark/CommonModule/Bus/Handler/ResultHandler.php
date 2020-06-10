<?php

namespace CarPark\CommonModule\Bus\Handler;


use CarPark\CommonModule\Bus\Handler\ResultHandlerInterface;

class ResultHandler implements ResultHandlerInterface
{
    /**
     * @var array
     */
    private $errors;

    /**
     * @var array
     */
    private $result = [];

    /**
     * @var int
     */
    private $statusCode;

    /**
     * @param array $errors
     * @return ResultHandlerInterface
     */
    public function setErrors(array $errors): ResultHandlerInterface
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $result
     * @return ResultHandlerInterface
     */
    public function setResult(array $result): ResultHandlerInterface
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    /**
     * @param int $code
     * @return ResultHandlerInterface
     */
    public function setStatusCode(int $code = 500): ResultHandlerInterface
    {
        $this->statusCode = $code;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
