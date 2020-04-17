<?php

namespace Deltoss\SentinelDatabasePermissions\Traits;

/**
 * Serves to override the functions
 * of the Sentinel permission trait
 * as to use abilities and
 * permissions from the database
 */
trait DatabasePermissionsTrait
{    
    /**
     * Checks a permission in the prepared array, including wildcard checks and permissions.
     *
     * @param array $prepared
     * @param string $permission
     * @return bool
     */
    protected function checkPermission(array $prepared, $permission) : bool
    {
        // With sentinel StandardPermissions, it
        // add user permissions to the END of the array,
        // where role permissions is situated at the
        // beginning of the array.
        //
        // As we want user permissions to take precedence
        // over role permissions for StandardPermissions,
        // we reverse the array and iterate through
        //
        // Note that StrictPermissions would be prepared
        // differently where they wouldn't have an issue
        // with this regardless which direction you
        // iterate through
        foreach (array_reverse($prepared) as $preparedPermission)
        {
            if ($preparedPermission->slug == $permission)
            {
                if ($preparedPermission->permission->allowed)
                    return true;
                else
                    return false;
            }
        }

        return false;
    }

    /**
     * Does the heavy lifting of preparing permissions.
     *
     * @param array $prepared
     * @param array $permissions
     * @return void
     */
    protected function preparePermissions(array &$prepared, array $permissions) : void
    {
        foreach ($permissions as $permission) {
            // Find the permission if it already exists
            $existingPermissionIndex = -1;
            for ($i = 0; $i < count($prepared); $i++)
            {
                $preparedPermission = $prepared[$i];
                if ($preparedPermission->id == $permission->id)
                {
                    $existingPermissionIndex = $i;
                    break;
                }
            }
            
            if ($existingPermissionIndex < 0) // If permission does not exists, we add it in
            {
                $prepared[] = $permission;
            }

            // If exists, we override the existing permission
            if ($existingPermissionIndex >= 0)
            {
                $prepared[$existingPermissionIndex] = $permission;
            }
        }
    }
}
