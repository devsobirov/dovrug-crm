<?php
namespace App\Traits;

use App\Roles\UserRoles;


trait HasRoles
{

    /**
     * Checking for is user has any roles
     * @return bool
     */
    public function hasAnyRole()
    {
        return !empty($this->getRoles());
    }

    /**
     * Checking has user required role
     * @param $role string
     * @return bool
     */
    public function hasRole($role)
    {
        if ($this->getMainRole() == UserRoles::ROLE_DIRECTOR) {
            return true;
        }
        return (boolean)in_array(mb_strtolower($role), $this->getRoles());
    }

    /**
     * Getting all roles user have;
     * @return array|null
     */
    public function getRoles()
    {
        $roles = $this->getAttribute('roles');

        if (is_null($roles)) {
            $roles = [];
        }

        return $roles;
    }

    /**
     * Gets main or highest user role;
     *
     * @return int|string|null
     */
    public function getMainRole()
    {
        $role = null;

        if ($this->hasAnyRole()) {
            foreach (UserRoles::$roleHierarchy as $mainRole => $subRolesArray) {
                $currentRoles = $this->getRoles();
                if (in_array($mainRole, $currentRoles)) {
                    $role = $mainRole;
                    break;
                }
            }
        }

        return $role;
    }

    /**
     * Adds new role to existing user's roles
     * @param string  $role
     * @return $this
     */
    public function addRole($role)
    {
        $roles = $this->getRoles();
        if ($this->isValidRole($role))
        {
            $roles[] = mb_strtolower($role);
            $roles = array_unique($roles);
            $this->setRoles($roles);
        }
        return $this;
    }

    /**
     * Gets public name of users role 
     * 
     * @param string $roleName
     * @return string|void
     */
    public function getRoleAlias($roleName)
    {
        $roleList = UserRoles::getRolesList();
        if (array_key_exists($roleName, $roleList))  {
            return $roleList[$roleName];
        }
    }

    /**
     * Gets related background color for users role
     *
     * @param string $roleName
     * @return string|void
     */
    public function getRoleColor($roleName)
    {
        $roleColors = UserRoles::getColorsForRoles();
        if (array_key_exists($roleName, $roleColors))  {
            return $roleColors[$roleName];
        }
    }

    /**
     * Checks is adding role exist in available roles list
     * @param string $role
     * @return bool
     */
    private function isValidRole($role)
    {
        return (bool) array_key_exists(mb_strtolower($role), UserRoles::getRolesList());
    }

    /**
     * @param array $roles
     * @return $this
     */
    private function setRoles($roles)
    {
        $this->setAttribute('roles', $roles);
        return $this;
    }
}
