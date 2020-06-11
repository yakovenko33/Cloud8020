<?php


namespace CarPark\UserModule\Application\GetCarPark\Exception;


use Throwable;

class BadDataException extends \Exception
{
    /**
     * @var array
     */
    private $error;

    /**
     * Pagination constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $this->error = ["validate" => ["Некоректно введены данные."]];
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array
     */
    public function getError(): array
    {
        return $this->error;
    }
}
