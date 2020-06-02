<?php


namespace CarPark\UserModule\Infrastructure\Laravel\Database\Modals;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    /**
     * @var string
     */
    protected $table = "roles";

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany("CarPark\UserModule\Infrastructure\Modals\User", "users_roles");
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany("CarPark\UserModule\Infrastructure\Modals\Permission", "roles_permission");
    }
}
