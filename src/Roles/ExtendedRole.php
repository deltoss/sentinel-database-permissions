<?php

namespace Deltoss\SentinelDatabasePermissions\Roles;

use Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility;
use Deltoss\SentinelDatabasePermissions\Traits\DatabasePermissibleTrait;
use Cartalyst\Sentinel\Roles\EloquentRole;

class ExtendedRole extends EloquentRole
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
     * The allowed abilities that the role has.
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
     * The rejected abilities that the role has.
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
     * The associated abilities that the role has, 
     * regardless whether the permission was denied/allowed.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAbilities() {
        return $this->abilities;
    }

    /**
     * The associated abilities that the role has, 
     * regardless whether the permission was denied/allowed.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function abilities()
    {
        // Note that the related model is set 
        // within the service provider, which
        // in turn extracts the model from the
        // config files.
        $abilitiesModelName = static::$abilitiesModel;
        return $this->belongsToMany($abilitiesModelName, 'role_permissions', 'role_id', 'ability_id')
            ->as('permission') // Pivot table settings
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
