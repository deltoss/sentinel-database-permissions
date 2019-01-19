<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole;
use Sentinel;

class RoleTest extends DatabaseTestCase
{
    public function testExtendedRoleModel()
    {
        $role = Sentinel::getRoleRepository()->createModel();
        $role->name = 'Administrator';
        $role->slug = 'administrator';

        $this->assertInstanceOf(ExtendedRole::class, $role);
    }
}