<?php

namespace Deltoss\SentinelDatabasePermissions\Permissions;

use Cartalyst\Sentinel\Permissions\StandardPermissions;
use Deltoss\SentinelDatabasePermissions\Traits\DatabasePermissionsTrait;

/**
 * Based on Sentinel's Standard Permission class.
 * 
 * Gives the user-based permissions a higher 
 * priority and will override role-based 
 * permissions. Any permissions granted/rejected 
 * on the user will always take precendece over 
 * any role-based permissions assigned
 */
class ExtendedStandardPermissions extends StandardPermissions
{
    use DatabasePermissionsTrait;
}
