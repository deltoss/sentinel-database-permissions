<?php

namespace Deltoss\SentinelDatabasePermissions\Traits;

use Mockery\Exception\BadMethodCallException;
use Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface;
use \Cartalyst\Sentinel\Permissions\PermissibleInterface;
use Exception;

/**
 * Serves to override the functions
 * of the Sentinel permissible trait
 * as to use abilities and
 * permissions from the database
 * 
 * Permissible trait are used
 * against the user or/and roles
 * to grant the various
 * methods to manage their
 * related permissions
 */
trait DatabasePermissibleTrait
{
    /**
     * Get mutator for the "permissions" attribute.
     *
     * @param mixed $permissions
     * @return array
     */
    public function getPermissionsAttribute($permissions)
    {
        // Note we don't use permissions, as that's from
        // the default sentinel's 'permission' column,
        // which should be removed
        
        // all() turns the collection object to an array of items
        $abilities = $this->getAbilities()->all();
        return $abilities;
    }

    /**
     * Set mutator for the "permissions" attribute.
     *
     * @param mixed $permissions  Can be an array of permission
     *                            IDs and the grant type, or
     *                            an array of permission 
     *                            objects
     * 
     * @return void
     */
    public function setPermissionsAttribute(array $abilities)
    {
        $eloquentFormattedAbilities = array();
        foreach($abilities as $key => $value)
        {
            // If it's an array of objects
            if (isset($value->id))
            {
                $eloquentFormattedAbilities[$value->id] = ['allowed' => true]; // Add the item, and set grant type to true
            }
            // If it's an array of ID integer
            else if (is_int($value))
            {
                $eloquentFormattedAbilities[$key] = ['allowed' => true]; // Add the item, and set grant type to true
            }
            // If it's an associative array with ID as key, and the grant type as value
            else if (is_int($key) && is_bool($value))
            {
                $eloquentFormattedAbilities[$key] = ['allowed' => $value]; // Add the item, and set grant type
            }
            else if (is_string($value)) // Else if it's an array of permission slugs (i.e. names)
            {
                $ability = static::getAbilitiesModel()::where('slug', $value)->first(); // model or null
                if (!$ability) {
                   throw new Exception('Could not find the permission with slug of \'' . $value . '\'');
                }
                $eloquentFormattedAbilities[$ability->id] = ['allowed' => true]; // Add the item, and set grant type to true
            }
            // If it's an associative array with slug as key, and the grant type as value
            else if (is_string($key) && is_bool($value))
            {
                $ability = static::getAbilitiesModel()::where('slug', $key)->first(); // model or null
                if (!$ability) {
                   throw new Exception('Could not find the permission with slug of \'' . $key . '\'');
                }
                $eloquentFormattedAbilities[$ability->id] = ['allowed' => $value]; // Add the item, and set grant type to true
            }
        }
        
        $this->abilities()->sync($eloquentFormattedAbilities);
        if ($this->relationLoaded('abilities')) // If relation is already loaded, update it
            $this->load('abilities');
        $this->permissionsInstance = null;
    }

    /**
     * {@inheritDoc}
     */
    public function addPermission(string $ability, bool $value = true) : PermissibleInterface
    {
        $abilityObject = $this->getAbility($ability);
        
        $this->abilities()->attach($abilityObject->getAbilityId(), ['allowed' => $value]);
        if ($this->relationLoaded('abilities')) // If relation is already loaded, update it
            $this->load('abilities');
        $this->permissionsInstance = null;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function updatePermission($ability, $value = true, $create = false) : PermissibleInterface
    {
        $abilityObject = $this->getAbility($ability);

        if ($this->getAbilities()->contains($abilityObject->getAbilityId()))
        {
            // Update the permissions on the database
            $this->abilities()->updateExistingPivot($abilityObject->getAbilityId(), ['allowed' => $value]);
            // Update the permissions on the cached abilities
            $existingAbility = $this->getAbilities()->first(function($value) use ($abilityObject) {
                return $abilityObject->getAbilityId() == $value->getAbilityId();
            });
            $existingAbility->permission->allowed = $value ? 1 : 0;
        }
        else if ($create)
        {
            $this->addPermission($abilityObject->getAbilityId(), $value);
        }
        $this->permissionsInstance = null;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function removePermission($ability) : PermissibleInterface
    {
        $abilityObject = $this->getAbility($ability);
        $index = $this->getAbilities()->search(function ($item, $key) use ($abilityObject) {
            return $item->getAbilityId() == $abilityObject->getAbilityId();
        });
        if ($index !== false)
        {
            // Detach from database
            $this->abilities()->detach($abilityObject->getAbilityId());
            // Detach from the cached abilities
            $this->getAbilities()->forget($index);
        }
        $this->permissionsInstance = null;
        return $this;
    }

    protected function getAbility($ability)
    {
        if (!($ability instanceof AbilityInterface))
        {
            $ability = static::getAbilitiesModel()::where('id', $ability)->orWhere('slug', $ability)->first();
        }
        return $ability;
    }
}
