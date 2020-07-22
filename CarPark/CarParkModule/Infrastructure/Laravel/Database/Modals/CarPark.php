<?php


namespace CarPark\CarParkModule\Infrastructure\Laravel\Database\Modals;


use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarPark extends Model
{
    /**
     * @var string
     */
    protected $table = 'car_parks';

    /**
     * @var bool
     */
    public $timestamps = true;//false;

    /**
     * @var array
     */
    protected $fillable = [
        "title",
        "address",
        'time_work',
        "created_at",
        "update_at"
    ];

    /**
     * @return BelongsToMany
     */
    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_parks_cars');
    }
}
