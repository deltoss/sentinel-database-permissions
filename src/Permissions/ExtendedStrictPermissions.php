<?php

namespace Deltoss\SentinelDatabasePermissions\Permissions;

use Cartalyst\Sentinel\Permissions\StrictPermissions;
use Deltoss\SentinelDatabasePermissions\Traits\DatabasePermissionsTrait;

/**
 * Based on Sentinel's Strict Permission class.
 * 
 * Will reject a permission as soon as one 
 * rejected permission is found on either 
 * the user or any of the assigned
 * roles. Granting a user a permission that
 * is rejected on a role he is assigned to
 * will not grant that user this permission.
 */
class ExtendedStrictPermissions extends StrictPermissions
{
    use DatabasePermissionsTrait;
}
