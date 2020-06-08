<?php


namespace Tests\UserModule\Helpers\DataClasses;


class SingInOrUp
{
    /**
     * @var array
     */
    private $request;

    /**
     * @var array
     */
    private $errors;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * SingInOrUp constructor.
     * @param array $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     */
    public function __construct(
        array $request,
        array $errors,
        string $status = "errors",
        int $statusCode = 422
    ) {
        $this->request = $request;
        $this->errors = $errors;
        $this->status = $status;
        $this->statusCode = $statusCode;
    }

    /**
     * @return array
     */
    public function getRequest(): array
    {
        return $this->request;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param array $request
     * @param array $errors
     * @param string $status
     * @param int $statusCode
     * @return $this
     */
    public static function create(
        array $request,
        array $errors,
        string $status = "errors",
        int $statusCode = 422
    ): self {
        return new self($request, $errors, $status, $statusCode);
    }
}
