<?php


namespace CarPark\UserModule\Infrastructure\Laravel\Database\Modals;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model
{
    use Authorizable;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * @return array
     */
    public function toJwtArray(): array
    {
        return [
            "id" => $this->id,
        ];
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany("CarPark\UserModule\Infrastructure\Modals\Role", "users_roles");
    }

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRoles(...$roles): bool
    {
        foreach($roles as $role) {
            if ($this->roles()->contains("name", $role)) {
                return true;
            }
        }
        return false;
    }
}