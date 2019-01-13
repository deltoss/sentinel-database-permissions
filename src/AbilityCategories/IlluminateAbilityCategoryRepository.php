<?php

namespace Deltoss\SentinelDatabasePermissions\AbilityCategories;

use Cartalyst\Support\Traits\RepositoryTrait;

class IlluminateAbilityCategoryRepository implements AbilityCategoryRepositoryInterface
{
    use RepositoryTrait;

    /**
     * The Eloquent role model name.
     *
     * @var string
     */
    protected $model = 'Deltoss\SentinelDatabasePermissions\AbilitCategory\EloquentAbilityCategory';

    /**
     * Create a new Illuminate role repository.
     *
     * @param string $model
     * @return void
     */
    public function __construct($model = null)
    {
        if (isset($model)) {
            $this->model = $model;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findById($id)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findByName($name)
    {
        return $this
            ->createModel()
            ->newQuery()
            ->where('name', $name)
            ->first();
    }
}
