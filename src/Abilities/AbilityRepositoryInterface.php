<?php

namespace Deltoss\SentinelDatabasePermissions\Abilities;

interface AbilityRepositoryInterface
{
    /**
     * Finds a role by the given primary key.
     *
     * @param int $id
     * @return \Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface
     */
    public function findById($id);

    /**
     * Finds a role by the given slug.
     *
     * @param string $slug
     * @return \Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface
     */
    public function findBySlug($slug);

    /**
     * Finds a role by the given name.
     *
     * @param string $name
     * @return \Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface
     */
    public function findByName($name);
}
