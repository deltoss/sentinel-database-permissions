<?php

namespace Deltoss\SentinelDatabasePermissions;

use Cartalyst\Sentinel\Sentinel;
use Cartalyst\Sentinel\Activations\ActivationRepositoryInterface;
use Cartalyst\Sentinel\Checkpoints\CheckpointInterface;
use Cartalyst\Sentinel\Persistences\PersistenceRepositoryInterface;
use Cartalyst\Sentinel\Reminders\ReminderRepositoryInterface;
use Cartalyst\Sentinel\Roles\RoleRepositoryInterface;
use Cartalyst\Sentinel\Users\UserRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;

use \Deltoss\SentinelDatabasePermissions\Abilities\AbilityRepositoryInterface;
use \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryRepositoryInterface;

class ExtendedSentinel extends Sentinel
{
    /**
     * The User repository.
     *
     * @var \Deltoss\SentinelDatabasePermissions\Abilities\AbilityRepositoryInterface
     */
    protected $abilities;

    /**
     * The Role repository.
     *
     * @var \Deltoss\SentinelDatabasePermissions\AbilityCategory\AbilityCategoryRepositoryInterface
     */
    protected $abilityCategories;

    /**
     * Create a new Sentinel instance.
     *
     * @param  \Cartalyst\Sentinel\Persistences\PersistenceRepositoryInterface  $persistence
     * @param  \Cartalyst\Sentinel\Users\UserRepositoryInterface  $users
     * @param  \Cartalyst\Sentinel\Roles\RoleRepositoryInterface  $roles
     * @param  \Deltoss\SentinelDatabasePermissions\Abilities\AbilityRepositoryInterface  $abilities
     * @param  \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryRepositoryInterface  $abilityCategories
     * @param  \Cartalyst\Sentinel\Activations\ActivationRepositoryInterface  $activations
     * @param  \Illuminate\Contracts\Events\Dispatcher  $dispatcher
     * @return void
     */
    public function __construct(
        PersistenceRepositoryInterface $persistences,
        UserRepositoryInterface $users,
        RoleRepositoryInterface $roles,
        AbilityRepositoryInterface $abilities,
        AbilityCategoryRepositoryInterface $abilityCategories,
        ActivationRepositoryInterface $activations,
        Dispatcher $dispatcher
    ) {
        parent::__construct($persistences, $users, $roles, $activations, $dispatcher);
        $this->abilities = $abilities;
        $this->abilityCategories = $abilityCategories;
    }

    /**
     * Returns the ability repository.
     *
     * @var \Deltoss\SentinelDatabasePermissions\Abilities\AbilityRepositoryInterface
     */
    public function getAbilityRepository()
    {
        return $this->abilities;
    }

    /**
     * Sets the ability repository.
     *
     * @param \Deltoss\SentinelDatabasePermissions\Abilities\AbilityRepositoryInterface
     * @return void
     */
    public function setAbilityRepository(AbilityRepositoryInterface $abilities)
    {
        $this->abilities = $abilities;
    }

    /**
     * Returns the ability category repository.
     *
     * @var \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryRepositoryInterface
     */
    public function getAbilityCategoryRepository()
    {
        return $this->abilityCategories;
    }

    /**
     * Sets the ability category repository.
     *
     * @param \Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryRepositoryInterface
     * @return void
     */
    public function setAbilityCategoryRepository(AbilityCategoryRepositoryInterface $abilityCategories)
    {
        $this->abilityCategories = $abilityCategories;
    }

    /**
     * Dynamically pass missing methods to Sentinel.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     * @throws \BadMethodCallException
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'findAbilityBy')) {
            $abilities = $this->getAbilityRepository();

            $method = 'findBy'.substr($method, 13);

            return call_user_func_array([$abilities, $method], $parameters);
        }

        if (starts_with($method, 'findAbilityCategoryBy')) {
            $abilityCategories = $this->getAbilityCategoryRepository();

            $method = 'findBy'.substr($method, 21);

            return call_user_func_array([$abilityCategories, $method], $parameters);
        }

        $methods = ['getAbilities', 'getAllowedAbilities', 'getRejectedAbilities', 'getAllAbilities', 'getAllAllowedAbilities', 'getAllRejectedAbilities'];

        $className = get_class($this);

        if (in_array($method, $methods)) {
            $user = $this->getUser();

            if ($user === null) {
                throw new BadMethodCallException("Method {$className}::{$method}() can only be called if a user is logged in.");
            }

            return call_user_func_array([$user, $method], $parameters);
        }

        return parent::__call($method, $parameters);
    }
}
