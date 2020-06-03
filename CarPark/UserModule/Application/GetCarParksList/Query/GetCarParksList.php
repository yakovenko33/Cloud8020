<?php


namespace CarPark\UserModule\Application\GetCarParksList\Query;


use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;

class GetCarParksList extends VerifyCommandQuery
{
    /**
     * GetCarParksList constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        parent::__construct($data["jwt"]);
    }
}
