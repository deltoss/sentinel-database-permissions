<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    | Please provide the ability model used in Sentinel.
    | Note this is added as part of the sentinel extension,
    | and is not part of the sentinel package itself
    |
    */

    'abilities' => [

        'model' => 'Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility',

    ],

    /*
    |--------------------------------------------------------------------------
    | Ability Categories
    |--------------------------------------------------------------------------
    |
    | Please provide the ability category model used in Sentinel.
    | Note this is added as part of the sentinel extension,
    | and is not part of the sentinel package itself
    |
    */

    'ability_categories' => [

        'model' => 'Deltoss\SentinelDatabasePermissions\AbilityCategories\EloquentAbilityCategory',

    ],
];
