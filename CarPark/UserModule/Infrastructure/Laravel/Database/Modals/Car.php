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
    public $timestamps = true;

    /**
     * @var array
     */
    protected $fillable = [
        "number_car",
        "driver_name",
        "user_id",
        "created_at",
        "update_at"
    ];

    /**
     * @return BelongsToMany
     */
    public function carParks(): BelongsToMany
    {
        return $this->belongsToMany(CarPark::class, 'car_parks_cars');
    }
}
