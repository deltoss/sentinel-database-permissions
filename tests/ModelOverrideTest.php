<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\Users\ExtendedUser;
use Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole;
use Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions;
use Sentinel;

class ModelOverrideTest extends DatabaseTestCase
{
    protected function resolveApplicationBootstrappers($app)
    {
        // Configure the configs BEFORE the service
        // provider gets bootstrapped, for the
        // custom Sentinel model overrides to
        // behave correctly.
        //
        // We do this by overriding the method
        // resolveApplicationBootstrappers().
        // For more information, refer to this PR:
        //   https://github.com/orchestral/testbench-core/pull/17
        $app['config']->set('cartalyst.sentinel.users.model', ExtendedUserOverride::class);
        $app['config']->set('cartalyst.sentinel.roles.model', ExtendedRoleOverride::class);
        $app['config']->set('cartalyst.sentinel.permissions.class', ExtendedStandardPermissionsOverride::class);

        parent::resolveApplicationBootstrappers($app);
    }
    
    public function testExtendedUserModel()
    {
        $user = Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);
        $this->assertInstanceOf(ExtendedUserOverride::class, $user);
    }

    public function testExtendedRoleModel()
    {
        $role = Sentinel::getRoleRepository()->createModel();
        $role->name = 'Administrator';
        $role->slug = 'administrator';

        $this->assertInstanceOf(ExtendedRoleOverride::class, $role);
    }

    public function testExtendedPermissionModel()
    {
        $user = Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);

        $this->assertInstanceOf(ExtendedStandardPermissionsOverride::class, $user->getPermissionsInstance());
    }
}

class ExtendedUserOverride extends ExtendedUser
{
}

class ExtendedRoleOverride extends ExtendedRole
{
}

class ExtendedStandardPermissionsOverride extends ExtendedStandardPermissions
{
}