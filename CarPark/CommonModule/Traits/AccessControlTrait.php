<?php


namespace CarPark\CommonModule\Traits;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use \Illuminate\Support\Collection;

trait AccessControlTrait
{
    /**
     * @var Collection
     */
    private $permissionsCache;

    /**
     * @param mixed ...$roles
     * @return bool
     */
    public function hasRoles(...$roles): bool
    {
        $rolesList = $this->roles()->get();
        foreach($roles as $role) {
            if ($rolesList->contains("name", $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param mixed ...$permissions
     * @return bool
     */
    public function hasPermissions(...$permissions): bool
    {
        $list = $this->getPermissions($this->id);
        foreach ($permissions as $permission) {
            if ($list->contains("permissions", $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param int $userId
     * @return Collection
     */
    private function getPermissions(int $userId): Collection
    {
        if (empty($this->permissionsCache)) {
            $this->permissionsCache = DB::table("users as u")
                ->select("p.id", "p.name as permissions")
                ->join("users_roles as u_r", "u.id", "=", "u_r.user_id")
                ->join("roles as r", "u_r.role_id", "=", "r.id")
                ->join("roles_permissions as r_p", "r.id", "=", "r_p.role_id")
                ->join("permissions as p", "r_p.permission_id", "=", "p.id")
                ->where("u.id", $userId)
                ->get();
        }

        return $this->permissionsCache;
    }

    /**
     * @return BelongsToMany
     */
    abstract public function roles(): BelongsToMany;
}
