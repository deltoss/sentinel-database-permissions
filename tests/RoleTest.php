<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole;
use Sentinel;

class RoleTest extends DatabaseTestCase
{
    public function testExtendedRoleModel()
    {
        // For this test, note we configured
        // the role model to be the ExtendedRole
        // instead of the default Sentinel's
        // role model within the DatabaseTestCase
        // class, inside the getEnvironmentSetUp()
        // method.
        
        $role = Sentinel::getRoleRepository()->createModel();
        $role->name = 'Administrator';
        $role->slug = 'administrator';

        $this->assertInstanceOf(ExtendedRole::class, $role);
    }
}