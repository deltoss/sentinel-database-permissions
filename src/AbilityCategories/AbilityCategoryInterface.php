<?php

namespace Deltoss\SentinelDatabasePermissions\AbilityCategories;

interface AbilityCategoryInterface
{
    /**
     * Returns the ability category's primary key.
     *
     * @return int
     */
    public function getAbilityCategoryId();

    /**
     * Returns the abilities model.
     *
     * @return string
     */
    public static function getAbilitiesModel();

    /**
     * Sets the abilities model.
     *
     * @param string $abilitiesModel
     * @return void
     */
    public static function setAbilitiesModel($abilitiesModel);

    /**
     * Get associated abilities under the category.
     */
    public function getAbilities();
}