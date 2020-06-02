<?php


namespace CarPark\UserModule\Infrastructure\Modals;

use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Silber\Bouncer\Database\HasRolesAndAbilities;

class User extends Model
{
    use HasRolesAndAbilities, Authorizable;

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
}
