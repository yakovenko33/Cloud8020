<?php


namespace CarPark\CarParkModule\Application\GetCarsList\Query;


use CarPark\CommonModule\Bus\Command\VerifyCommandQuery;

class GetCarsList extends VerifyCommandQuery
{
    /**
     * GetCarsList constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data["jwt"]);
    }
}
