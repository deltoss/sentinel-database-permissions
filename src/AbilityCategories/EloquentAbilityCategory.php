<?php

namespace Deltoss\SentinelDatabasePermissions\AbilityCategories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface;

/**
 * Category which groups the abilities. Serves no purposes
 * with the process of checking permissions. It only
 * serves to group permissions into more user-friendly
 * and manageable categories.
 */
class EloquentAbilityCategory extends Model implements AbilityCategoryInterface
{
    /**
     * Lets Eloquent know the correct SQL table
     *
     * @var string
     */
    protected $table = 'ability_categories';

    /**
     * {@inheritDoc}
     */
    protected $fillable = [
        'name'
    ];

    /**
     * {@inheritDoc}
     */
    public function getAbilityCategoryId()
    {
        return $this->getKey();
    }

    /**
     * The Eloquent abilities model name.
     *
     * @var string
     */
    protected static $abilitiesModel = 'Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility';

    /**
     * {@inheritDoc}
     */
    public static function getAbilitiesModel()
    {
        return static::$abilitiesModel;
    }

    /**
     * {@inheritDoc}
     */
    public static function setAbilitiesModel($abilitiesModel)
    {
        static::$abilitiesModel = $abilitiesModel;
    }

    /**
     * {@inheritDoc}
     */
    public function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * The abilities that the ability category has.
     */
    public function abilities()
    {
        // Note that the related model is set 
        // within the service provider, which
        // in turn extracts the model from the
        // config files.
        $abilitiesModelName = static::$abilitiesModel;
        return $this->hasMany($abilitiesModelName, 'ability_category_id');
    }
}
