<?php

namespace Deltoss\SentinelDatabasePermissions\Abilities;

interface AbilityInterface
{
    /**
     * Returns the ability's primary key.
     *
     * @return int
     */
    public function getAbilityId();

    /**
     * Returns the ability's slug.
     *
     * @return string
     */
    public function getAbilitySlug();

    /**
     * Returns the ability categories model.
     *
     * @return string
     */
    public static function getAbilityCategoriesModel();

    /**
     * Sets the ability categories model.
     *
     * @param string $abilityCategoriesModel
     * @return void
     */
    public static function setAbilityCategoriesModel($abilityCategoriesModel);

    /**
     * Returns the users model.
     *
     * @return string
     */
    public static function getUsersModel();

    /**
     * Sets the users model.
     *
     * @param string $usersModel
     * @return void
     */
    public static function setUsersModel($usersModel);

    /**
     * Returns all users for the ability.
     *
     * @return \IteratorAggregate
     */
    public function getUsers();

    /**
     * Returns the roles model.
     *
     * @return string
     */
    public static function getRolesModel();

    /**
     * Sets the roles model.
     *
     * @param string $rolesModel
     * @return void
     */
    public static function setRolesModel($rolesModel);

    /**
     * Returns all roles for the ability.
     *
     * @return \IteratorAggregate
     */
    public function getRoles();

    /**
     * Returns the category for the ability.
     * 
     * @return \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface
     */
    public function getAbilityCategory();

    /**
     * Returns all directly and indirectly 
     * (e.g. via roles) associated users 
     * for the ability.
     * 
     * @return \IteratorAggregate
     */
    public function getAllUsers();

    /**
     * Returns all directly and indirectly 
     * (e.g. via roles) associated users 
     * that has allowed access for the 
     * ability.
     * 
     * @return \IteratorAggregate
     */
    public function getAllAllowedUsers();
    
    /**
     * Returns all directly and indirectly 
     * (e.g. via roles) associated users 
     * that has rejected access for the 
     * ability.
     * 
     * @return \IteratorAggregate
     */
    public function getAllRejectedUsers();
}
