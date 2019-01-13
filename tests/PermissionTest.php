<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions;
use Sentinel;

class PermissionTest extends DatabaseTestCase
{
    public function testExtendedPermissionModel()
    {
        // For this test, note we configured
        // the permission model to be the
        // ExtendedStandardPermissions instead
        // of the default Sentinel's permission
        // model within the DatabaseTestCase
        // class, inside the getEnvironmentSetUp()
        // method.

        $user = Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);

        $this->assertInstanceOf(ExtendedStandardPermissions::class, $user->getPermissionsInstance());
    }
}