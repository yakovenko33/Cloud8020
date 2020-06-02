<?php


namespace CarPark\UserModule\Infrastructure\Modals;


use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarPark extends Model
{
    /**
     * @var string
     */
    protected $table = 'cars_parks';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        "title",
        "address",
        'time_work'
    ];

    /**
     * @return BelongsToMany
     */
    public function cars(): BelongsToMany
    {
        return $this->belongsToMany('CarPark\UserModule\Infrastructure\Modals\Car', 'cars_parks_cars');
    }
}
