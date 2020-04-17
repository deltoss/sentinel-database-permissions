<?php

namespace Deltoss\SentinelDatabasePermissions\AbilityCategories;

interface AbilityCategoryRepositoryInterface
{
    /**
     * Finds a role by the given primary key.
     *
     * @param int $id
     * @return \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface
     */
    public function findById($id);

    /**
     * Finds a role by the given name.
     *
     * @param string $name
     * @return \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface
     */
    public function findByName($name);
}
