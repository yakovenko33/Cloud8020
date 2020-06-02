<?php


namespace CarPark\UserModule\Infrastructure\Laravel\Database\Modals;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    /**
     * @var string
     */
    protected $table = 'cars';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        "number_car",
        "driver_name"
    ];

    /**
     * @return BelongsToMany
     */
    public function carParks(): BelongsToMany
    {
        return $this->belongsToMany('CarPark\UserModule\Infrastructure\Modals\CarPark', 'cars_parks_cars');
    }
}
