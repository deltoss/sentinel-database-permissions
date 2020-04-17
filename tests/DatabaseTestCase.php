<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Cartalyst\Sentinel\Laravel\SentinelServiceProvider;
use Deltoss\SentinelDatabasePermissions\Providers\SentinelDatabasePermissionsServiceProvider;
use Orchestra\Testbench\TestCase;
use Deltoss\SentinelDatabasePermissions\Users\ExtendedUser;
use Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole;
use Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions;

/**
 * PhpUnit Test Case class that was made based
 * on Laravel so it can perform Integration
 * tests using Eloquent models.
 * 
 * For more information, refer to:
 *   https://stackoverflow.com/questions/27759301/setting-up-integration-tests-in-a-laravel-package
 *   https://github.com/orchestral/testbench
 */
abstract class DatabaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [SentinelServiceProvider::class, SentinelDatabasePermissionsServiceProvider::class];
    }

    /**
     * Setup DB before each test.
     *
     * @return void  
     */
    public function setUp() : void
    { 
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/../vendor/cartalyst/sentinel/src/migrations');
        $this->loadMigrationsFrom(__DIR__ . '/../publishable/database/migrations');
    }

    protected function getPackageAliases($app)
    {
        return [
            'Sentinel' => 'Cartalyst\Sentinel\Laravel\Facades\Sentinel'
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}