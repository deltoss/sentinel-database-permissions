<?php

namespace Deltoss\SentinelDatabasePermissions\Users;

use Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility;
use Deltoss\SentinelDatabasePermissions\Traits\DatabasePermissibleTrait;
use Cartalyst\Sentinel\Users\EloquentUser;

class ExtendedUser extends EloquentUser
{
    use DatabasePermissibleTrait;

    /**
     * The Eloquent abilities model name.
     *
     * @var string
     */
    protected static $abilitiesModel = 'Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility';

    /**
     * Returns the abilities model.
     *
     * @return string
     */
    public static function getAbilitiesModel()
    {
        return static::$abilitiesModel;
    }

    /**
     * Sets the abilities model.
     *
     * @param string $abilitiesModel
     * @return void
     */
    public static function setAbilitiesModel($abilitiesModel)
    {
        static::$abilitiesModel = $abilitiesModel;
    }

    /**
     * Get the abilities that the user has.
     * Does not include abilities indirectly
     * assigned to the user (e.g. via roles).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAbilities() {
        return $this->abilities;
    }

    /**
     * Get the abilities that comes from
     * the assigned user roles, regardless
     * whether the permission was denied/allowed.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getAbilitiesGivenByRoles()
    {
        $roles = $this->roles()->get();
        $abilities = collect([]);

        foreach ($roles as $role)
        {
            $roleAbilities = $role->abilities->all();
            $abilities = $abilities->concat($roleAbilities);
        }
        $abilities = $abilities->unique(function ($item) {
            return $item->getAbilityId();
        });
        return $abilities;
    }
    
    /**
     * The allowed abilities that the user has.
     * Does not include abilities indirectly
     * assigned to the user (e.g. via roles).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllowedAbilities()
    {
        $abilities = $this->getAbilities();
        // The above only return connected abilities
        // Abilities can be assigned to the user or role,
        // but be as either allowed or rejected.
        // Hence we do an additional filtering step.
        $abilities = $abilities->filter(function ($value, $key) {
            return $value->permission->allowed == true;
        });
        return $abilities;
    }

    /**
     * The rejected abilities that the user has.
     * Does not include abilities indirectly
     * assigned to the user (e.g. via roles).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRejectedAbilities()
    {
        $abilities = $this->getAbilities();
        // The above only return connected abilities
        // Abilities can be assigned to the user or role,
        // but be as either allowed or rejected.
        // Hence we do an additional filtering step.
        $abilities = $abilities->filter(function ($value, $key) {
            return $value->permission->allowed == false;
        });
        return $abilities;
    }

    /**
     * Get all abilities for the user.
     * Includes abilities indirectly assigned to the user.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllAbilities()
    {
        $roleAbilities = $this->getAbilitiesGivenByRoles();
        $userAbilities = $this->abilities()->get()->all();
        $abilities = collect($roleAbilities)->concat($userAbilities);
        $abilities = $abilities->unique(function ($item) {
            return $item->getAbilityId();
        });
        return $abilities;
    }

    /**
     * The allowed abilities that the user has.
     * Includes abilities indirectly assigned to the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllAllowedAbilities()
    {
        $abilities = $this->getAllAbilities();
        // The above only return connected abilities
        // Abilities can be assigned to the user or role,
        // but be as either allowed or rejected.
        // Hence we do an additional filtering step.
        $abilities = $abilities->filter(function ($value, $key) {
            return $this->hasAccess($value->getAbilitySlug());
        });
        return $abilities;
    }

    /**
     * The rejected abilities that the user has.
     * Includes abilities indirectly assigned to the user.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRejectedAbilities()
    {
        $abilities = $this->getAllAbilities();
        // The above only return connected abilities
        // Abilities can be assigned to the user or role,
        // but be as either allowed or rejected.
        // Hence we do an additional filtering step.
        $abilities = $abilities->filter(function ($value, $key) {
            return !($this->hasAccess($value->getAbilitySlug()));
        });
        return $abilities;
    }

    /**
     * The associated abilities that the user has,
     * regardless whether the permission was denied/allowed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function abilities()
    {
        // Note that the related model is set 
        // within the service provider, which
        // in turn extracts the model from the
        // config files.
        $abilitiesModelName = static::$abilitiesModel;
        return $this->belongsToMany($abilitiesModelName, 'user_permissions', 'user_id', 'ability_id')
            ->as('permission')
            ->withPivot('allowed') // Define the extra pivot table's columns, excluding the IDs
            ->withTimestamps();
    }

    /**
     * {@inheritDoc}
     */
    public function delete()
    {
        $isSoftDeleted = array_key_exists('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this));

        if ($this->exists && ! $isSoftDeleted) {
            $this->abilities()->detach();
        }

        return parent::delete();
    }
}
