<?php
namespace Deltoss\SentinelDatabasePermissions\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Deltoss\SentinelDatabasePermissions\ExtendedSentinel;

use Deltoss\SentinelDatabasePermissions\Users\ExtendedUser;
use Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole;
use Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions;
use Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStrictPermissions;
use Deltoss\SentinelDatabasePermissions\Abilities\IlluminateAbilityRepository;
use Deltoss\SentinelDatabasePermissions\AbilityCategories\IlluminateAbilityCategoryRepository;
use Symfony\Component\HttpFoundation\Response;

class SentinelDatabasePermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {   
        $this->prepareResources();
        $this->registerAbilities();
        $this->registerAbilityCategories();
        $this->extendSentinel();
        $this->setConfigOverrides();
        $this->setSentinelOverrides();
        $this->setModelOverrides();
    }

    /**
     * Prepare the package resources.
     *
     * @return void
     */
    protected function prepareResources()
    {
        // Load the configuration file, and configure them to be publishable
        if (file_exists(config_path('sentinel.database.permissions.php')))
        {
            $this->mergeConfigFrom(config_path('sentinel.database.permissions.php'), 'sentinel.database.permissions');
        }
        else
        {
            $this->mergeConfigFrom(__DIR__ . '/../../publishable/config/sentinel.database.permissions.php', 'sentinel.database.permissions');
        }

        $this->publishes([
            __DIR__ . '/../../publishable/config/sentinel.database.permissions.php' => config_path('sentinel.database.permissions.php'),
        ], 'config');

        // Load the migrations, and configure them to be publishable
        if (is_dir(base_path('/database/vendor/sentinel-database-permissions/migrations')))
            $this->loadMigrationsFrom(base_path('/database/vendor/sentinel-database-permissions/migrations'));
        else
            $this->loadMigrationsFrom(__DIR__ . '/../../publishable/database/migrations');
            
        $this->publishes([
            __DIR__ . '/../../publishable/database/migrations' => base_path('/database/vendor/sentinel-database-permissions/migrations'),
        ], 'migrations');
    }

    /**
     * Extends sentinel.
     *
     * @return void
     */
    protected function extendSentinel()
    {
        $this->app->extend('sentinel', function ($sentinel, $app) {
            $extendedSentinel = new ExtendedSentinel(
                $app['sentinel.persistence'],
                $app['sentinel.users'],
                $app['sentinel.roles'],
                $app['sentinel.abilities'],
                $app['sentinel.ability_categories'],
                $app['sentinel.activations'],
                $app['events']
            );

            $this->configureSentinel($extendedSentinel, $app);

            return $extendedSentinel;
        });

        $this->app->alias('sentinel', 'Cartalyst\Sentinel\Sentinel');
    }

    /**
     * Configures the sentinel object.
     *
     * @return void
     */
    protected function configureSentinel($sentinel, $app) {
        if (isset($app['sentinel.checkpoints'])) {
            foreach ($app['sentinel.checkpoints'] as $key => $checkpoint) {
                $sentinel->addCheckpoint($key, $checkpoint);
            }
        }

        $sentinel->setActivationRepository($app['sentinel.activations']);
        $sentinel->setReminderRepository($app['sentinel.reminders']);

        $sentinel->setRequestCredentials(function () use ($app) {
            $request = $app['request'];

            $login = $request->getUser();
            $password = $request->getPassword();

            if ($login === null && $password === null) {
                return;
            }

            return compact('login', 'password');
        });

        $sentinel->creatingBasicResponse(function () {
            $headers = ['WWW-Authenticate' => 'Basic'];

            return new Response('Invalid credentials.', 401, $headers);
        });
    }

    /**
     * Registers the abilities.
     *
     * @return void
     */
    protected function registerAbilities()
    {
        $this->app->singleton('sentinel.abilities', function ($app) {
            $config = $app['config']->get('sentinel.database.permissions.abilities');

            return new IlluminateAbilityRepository($config['model']);
        });
    }

    /**
     * Registers the abilities.
     *
     * @return void
     */
    protected function registerAbilityCategories()
    {
        $this->app->singleton('sentinel.ability_categories', function ($app) {
            $config = $app['config']->get('sentinel.database.permissions.ability_categories');

            return new IlluminateAbilityCategoryRepository($config['model']);
        });
    }
    
    /**
     * Performs the necessary overrides to adjust the Sentinel config values.
     *
     * @return void
     */
    protected function setConfigOverrides()
    {
        $sentinelConfig = $this->app['config']->get('cartalyst.sentinel');
        $userModel = $sentinelConfig['users']['model'];
        if (!is_subclass_of($userModel, ExtendedUser::class))
            $userModel = ExtendedUser::class;
        $roleModel = $sentinelConfig['roles']['model'];
        if (!is_subclass_of($roleModel, ExtendedRole::class))
            $roleModel = ExtendedRole::class;
        $permissionModel = $sentinelConfig['permissions']['class'];
        if (!is_subclass_of($permissionModel, ExtendedStandardPermissions::class) && !is_subclass_of($permissionModel, ExtendedStrictPermissions::class))
            $permissionModel = ExtendedStandardPermissions::class;
        
        config([
            'cartalyst.sentinel.users.model' => $userModel,
            'cartalyst.sentinel.roles.model' => $roleModel,
            'cartalyst.sentinel.permissions.class' => $permissionModel,
        ]);
    }

    /**
     * Set the overrides for Sentinel models.
     *
     * @return void
     */
    protected function setSentinelOverrides()
    {
        // We do the Sentinel overrides again,
        // as Sentinel Database Permissions
        // automatically changes the used
        // models conditionally.
        $sentinelConfig = $this->app['config']->get('cartalyst.sentinel');
        $users = $sentinelConfig['users']['model'];
        $roles = $sentinelConfig['roles']['model'];
        $permissions = $sentinelConfig['permissions']['class'];

        if (class_exists($users)) {
            if (method_exists($users, 'setRolesModel')) {
                forward_static_call_array([ $users, 'setRolesModel' ], [ $roles ]);
            }

            if (method_exists($users, 'setPermissionsClass')) {
                forward_static_call_array([ $users, 'setPermissionsClass' ], [ $permissions ]);
            }
        }

        if (class_exists($roles) && method_exists($roles, 'setUsersModel')) {
            forward_static_call_array([ $roles, 'setUsersModel' ], [ $users ]);
        }
    }

    /**
     * Performs the necessary overrides to set the
     * Sentinel and permission models from the configs.
     *
     * @return void
     */
    protected function setPermissionOverrides()
    {
        $sentinelConfig = $this->app['config']->get('cartalyst.sentinel');
        $sentinelDatabasePermissionsConfig = $this->app['config']->get('sentinel.database.permissions');

        $users = $sentinelConfig['users']['model'];
        $roles = $sentinelConfig['roles']['model'];
        $permissions = $sentinelConfig['permissions']['class'];

        $abilities = null;
        if (isset($sentinelDatabasePermissionsConfig['abilities']))
            $abilities = $sentinelDatabasePermissionsConfig['abilities']['model'];
        else
            $abilities = \Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility::class;

        $abilityCategories = null;
        if (isset($sentinelDatabasePermissionsConfig['ability_categories']))
            $abilityCategories = $sentinelDatabasePermissionsConfig['ability_categories']['model'];
        else
            $abilityCategories = \Deltoss\SentinelDatabasePermissions\AbilityCategories\EloquentAbilityCategory::class;

        if (class_exists($users)) {
            if (method_exists($users, 'setAbilitiesModel')) {
                forward_static_call_array([ $users, 'setAbilitiesModel' ], [ $abilities ]);
            }
        }

        if (class_exists($roles) && method_exists($roles, 'setAbilitiesModel')) {
            forward_static_call_array([ $roles, 'setAbilitiesModel' ], [ $abilities ]);
        }

        if (class_exists($abilities)) {
            if (method_exists($abilities, 'setUsersModel')) {
                forward_static_call_array([ $abilities, 'setUsersModel' ], [ $users ]);
            }
            if (method_exists($abilities, 'setRolesModel')) {
                forward_static_call_array([ $abilities, 'setRolesModel' ], [ $roles ]);
            }
            if (method_exists($abilities, 'setAbilityCategoriesModel')) {
                forward_static_call_array([ $abilities, 'setAbilityCategoriesModel' ], [ $abilityCategories ]);
            }
        }

        if (class_exists($abilityCategories)) {
            if (method_exists($abilityCategories, 'setAbilitiesModel')) {
                forward_static_call_array([ $abilityCategories, 'setAbilitiesModel' ], [ $abilities ]);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    protected $defer = true;

    /**
     * {@inheritDoc}
     */
    public function provides()
    {
        $originalProvides = (new SentinelServiceProvider($this->app))->provides();
        return array_merge($originalProvides, [
            'sentinel.abilities',
            'sentinel.ability_categories'
        ]);
    }
}