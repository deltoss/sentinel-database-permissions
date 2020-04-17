<?php

namespace Deltoss\SentinelDatabasePermissions\Abilities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface;

class EloquentAbility extends Model implements AbilityInterface
{
    /**
     * Lets Eloquent know the correct SQL table
     *
     * @var string
     */
    protected $table = 'abilities';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * {@inheritDoc}
     */
    public function getAbilityId()
    {
        return $this->getKey();
    }

    /**
     * {@inheritDoc}
     */
    public function getAbilitySlug()
    {
        return $this->slug;
    }

    /**
     * The Eloquent roles model name.
     *
     * @var string
     */
    protected static $rolesModel = 'Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole';

    /**
     * {@inheritDoc}
     */
    public static function getRolesModel()
    {
        return static::$rolesModel;
    }

    /**
     * {@inheritDoc}
     */
    public static function setRolesModel($rolesModel)
    {
        static::$rolesModel = $rolesModel;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * The Eloquent users model name.
     *
     * @var string
     */
    protected static $usersModel = 'Deltoss\SentinelDatabasePermissions\Users\ExtendedUser';

    /**
     * {@inheritDoc}
     */
    public static function getUsersModel()
    {
        return static::$usersModel;
    }

    /**
     * {@inheritDoc}
     */
    public static function setUsersModel($usersModel)
    {
        static::$usersModel = $usersModel;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllUsers()
    {
        $allAssignedUsers = $this->getUsers();
        if (!$allAssignedUsers)
            $allAssignedUsers = collect([]);
        $allAssignedUsers = $allAssignedUsers->merge($this->getUsersViaRole());

        $allAssignedUsers = $allAssignedUsers->unique(function ($user) {
            return $user->getUserId();
        });

        return $allAssignedUsers;
    }

    /**
     * {@inheritDoc}
     */
    public function getAllAllowedUsers()
    {
        return $this->getAllUsers()->filter(function ($user) {
            if ($user->hasAccess($this->slug))
                return true;
            return false;
        });
    }   
    
    /**
     * {@inheritDoc}
     */
    public function getAllRejectedUsers()
    {
        return $this->getAllUsers()->filter(function ($user) {
            if ($user->hasAccess($this->slug))
                return false;
            return true;
        });
    }

    /**
     * The Eloquent ability categories model name.
     *
     * @var string
     */
    protected static $abilityCategoriesModel = 'Deltoss\SentinelDatabasePermissions\AbilityCategories\EloquentAbilityCategory';

    /**
     * {@inheritDoc}
     */
    public static function getAbilityCategoriesModel()
    {
        return static::$abilityCategoriesModel;
    }

    /**
     * {@inheritDoc}
     */
    public static function setAbilityCategoriesModel($abilityCategoriesModel)
    {
        static::$abilityCategoriesModel = $abilityCategoriesModel;
    } 

    /**
     * {@inheritDoc}
     */
    public function getAbilityCategory() {
        return $this->abilityCategory;
    }
    
    /**
     * The roles that the permission belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        // Note that the related model is set 
        // within the service provider, which
        // in turn extracts the model from the
        // config files.
        $roleModelName = static::$rolesModel;
        return $this->belongsToMany($roleModelName, 'role_permissions', 'ability_id', 'role_id')
            ->as('role_permission') // Pivot table settings
            ->withPivot('allowed') // Define the extra pivot table's columns, excluding the IDs
            ->withTimestamps();
    }

    /**
     * The users that the permission belongs to.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        // Note that the related model is set 
        // within the service provider, which
        // in turn extracts the model from the
        // config files.
        $userModelName = static::$usersModel;
        return $this->belongsToMany($userModelName, 'user_permissions', 'ability_id', 'user_id')
            ->as('user_permission') // Pivot table settings
            ->withPivot('allowed') // Define the extra pivot table's columns, excluding the IDs
            ->withTimestamps();
    }

    /**
     * The category that the permission belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function abilityCategory()
    {
        // Note that the related model is set 
        // within the service provider, which
        // in turn extracts the model from the
        // config files.
        $abilityCategoryModelName = static::$abilityCategoriesModel;
        return $this->belongsTo($abilityCategoryModelName, 'ability_category_id');
    }

    /**
     * Get all users via the roles
     * that has this ability.
     * 
     * @return \Illuminate\Support\Collection
     */
    protected function getUsersViaRole()
    {
        $usersViaRole = collect([]);
        $rolesWithPermission = $this->getRoles();
        foreach($rolesWithPermission as $roleWithPermission)
        {
            foreach($roleWithPermission->getUsers() as $user)
            {
                $usersViaRole->push($user);
            }
        }

        $usersViaRole = $usersViaRole->unique(function ($user) {
            return $user->getUserId();
        });

        return $usersViaRole;
    }
}
