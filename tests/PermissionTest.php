<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions;
use Sentinel;

class PermissionTest extends DatabaseTestCase
{
    public function testExtendedPermissionModel()
    {
        $user = Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);

        $this->assertInstanceOf(ExtendedStandardPermissions::class, $user->getPermissionsInstance());
    }
}