# Managing Permissions

Just like with Sentinel, you can use the `addPermission`, `updatePermission`, and `removePermission` method. However, you can pass in a ability **slug**, an **ability** object, or an **ability** ID. Note that you also don't need to call the `save` method to persist the changes to the permission. For more information, see the usage examples with [users](#users) and [roles](#roles).

# Users

## Adding Permission

Note before you use any of the below approaches to add a permission, you must already have created the ability in the database. For more information, see (creating abilities)[#abilities-creating].

Code example adding permission using an ability ID:
```php
$user = Sentinel::findUserById(1);
// First parameter is the ability.
// Second parameter indicates whether
// to allow/deny the ability.
$user->addPermission(1, true);
```

Code example adding permission using an ability object:
```php
$user = Sentinel::findUserById(1);
$ability = Sentinel::findAbilityById(1);
$user->addPermission($ability, true);
```

Code example adding permission using an ability slug:
```php
$user = Sentinel::findUserById(1);
$user->addPermission('viewroles', true);
```

## Removing Permission

Code example removing permission using an ability ID:
```php
$user = Sentinel::findUserById(1);
$user->removePermission(1);
```

Code example removing permission using an ability object:
```php
$user = Sentinel::findUserById(1);
$ability = Sentinel::findAbilityById(1);
$user->removePermission($ability);
```

Code example removing permission using an ability slug:
```php
$user = Sentinel::findUserById(1);
$user->removePermission('viewroles');
```

## Updating Permission

Code example updating permission using an ability ID:
```php
$user = Sentinel::findUserById(1);
// First parameter is the ability.
// Second parameter indicates whether
// to allow/deny the ability
// Third parameter indicates whether
// to add the ability if it doesn't
// exist. By default, it's false.
$user->updatePermission(1, false, true);
```

Code example updating permission using an ability object:
```php
$user = Sentinel::findUserById(1);
$ability = Sentinel::findAbilityById(1);
$user->updatePermission($ability, false, true);
```

Code example updating permission using an ability slug:
```php
$user = Sentinel::findUserById(1);
$user->updatePermission('viewroles', false, true);
```


## Checking for Access
Like Sentinel, you can use `hasAccess` and `hasAnyAccess` as below:

Code example for checking access with logged-in user:
```php
// Must have ALL specified permissions
// to get into this if statement
if (Sentinel::hasAccess('viewroles', 'editroles'))
{
    // ...Do something
}

// Must have at least one of the specified
// permissions to get into this if statement
if (Sentinel::hasAnyAccess('viewroles', 'editroles'))
{
    // ...Do something
}
```

Code example for checking access with a user:
```php
$user = Sentinel::findUserById(1);

// Must have ALL specified permissions
// to get into this if statement
if ($user->hasAccess('viewroles', 'editroles'))
{
    // ...Do something
}

// Must have at least one of the specified
// permissions to get into this if statement
if ($user->hasAnyAccess('viewroles', 'editroles'))
{
    // ...Do something
}
```

## Get Associated Abilities
There are various methods you can use to access the list of associated abilities.
Here is a short list of the differences between the various methods:

| Method                    | Returns          | Description                            |
| ------------------------- | ---------------- | -------------------------------------- |
| `getAbilities`            | Collection       | Gets the assigned abilities of the user. This **does not include** abilities through roles. |
| `getAllowedAbilities`     | Collection       | Gets the assigned **allowed** abilities of the user. This **does not include** abilities through roles. |
| `getRejectedAbilities`    | Collection       | Gets the assigned **rejected** abilities of the user. This **does not include** abilities through roles. |
| `getAllAbilities`         | Collection       | Gets the assigned abilities of the user. This **includes** abilities through roles. |
| `getAllAllowedAbilities`  | Collection       | Gets the assigned **allowed** abilities of the user. This **includes** abilities through roles. |
| `getAllRejectedAbilities` | Collection       | Gets the assigned **rejected** abilities of the user. This **includes** abilities through roles. |

Code example with user loaded from database:
```php
$user = Sentinel::findUserById(1);
$abilities = $user->getAllAbilities(); // getAllAbilities() returns a Laravel collection object
foreach ($abilities as $ability)
{
    if ($ability->permission->allowed)
    {
        // ... Do something if permission is allowed
    }
}
```

Code example with currently logged in user:
```php
$abilities = Sentinel::getAllAbilities(); // getAllAbilities() returns a Laravel collection object
foreach ($abilities as $ability)
{
    if ($ability->permission->allowed)
    {
        // ... Do something if permission is allowed
    }
}
```

# Roles

## Adding Permission

Note before you use any of the below approaches to add a permission, you must already have created the ability in the database. For more information, see (creating abilities)[#abilities-creating].

Code example adding permission using an ability ID:
```php
$role = Sentinel::findRoleById(1);

// First parameter is the ability.
// Second parameter indicates whether
// to allow/deny the ability
$role->addPermission(1, true);
```

Code example adding permission using an ability object:
```php
$role = Sentinel::findRoleById(1);
$ability = Sentinel::findAbilityById(1);
$role->addPermission($ability, true);
```

Code example adding permission using an ability slug:
```php
$role = Sentinel::findRoleById(1);
$role->addPermission('viewroles', true);
```

## Removing Permission

Code example removing permission using an ability ID:
```php
$role = Sentinel::findRoleById(1);
$role->removePermission(1);
```

Code example removing permission using an ability object:
```php
$role = Sentinel::findRoleById(1);
$ability = Sentinel::findAbilityById(1);
$role->removePermission($ability);
```

Code example removing permission using an ability slug:
```php
$role = Sentinel::findRoleById(1);
$role->removePermission('viewroles');
```

## Updating Permission

Code example updating permission using an ability ID:
```php
$role = Sentinel::findRoleById(1);

// Second parameter indicates
// whether to allow/deny the ability

// Third parameter indicates whether
// to add the ability if it doesn't
// exist. By default, it's false.
$role->updatePermission(1, false, true);
```

Code example updating permission using an ability object:
```php
$role = Sentinel::findRoleById(1);
$ability = Sentinel::findAbilityById(1);
$role->updatePermission($ability, false, true);
```

Code example updating permission using an ability slug:
```php
$role = Sentinel::findRoleById(1);
$role->updatePermission('viewroles', false, true);
```

## Get Associated Abilities

Roles, unlike users, can't have indirect permissions, and as such has fewer methods of retrieving associated abilities.

| Method                 | Returns          | Description                            |
| ---------------------- | ---------------- | -------------------------------------- |
| `getAbilities`         | Collection       | Gets the assigned abilities of the role. |
| `getAllowedAbilities`  | Collection       | Gets the assigned **allowed** abilities of the role. |
| `getRejectedAbilities` | Collection       | Gets the assigned **rejected** abilities of the role. |

Code example:
```php
$role = Sentinel::findRoleById(1);
$abilities = $role->getAbilities(); // getAbilities() returns a Laravel collection object
foreach ($abilities as $ability)
{
    if ($ability->permission->allowed)
    {
        // ... Do something if permission is allowed
    }
}
```

# Abilities

## Listing

Code example:
```php
$abilities = Sentinel::getAbilityRepository()->orderBy('name', 'ASC')->get();
```

## Creating

Code example:
```php
$abilityCategory = Sentinel::findAbilityCategoryByName('Roles');
// If the ability category doesn't exist, we'll create it
if (!$abilityCategory)
{
    $abilityCategory = Sentinel::getAbilityCategoryRepository()->createModel();
    $abilityCategory->name = 'Roles';
    $abilityCategory->save();
}

// Create the ability and assign it to the ability category
$ability = Sentinel::getAbilityRepository()->createModel();
$ability->name = 'View Roles';
$ability->slug = 'viewroles';
$ability->ability_category_id = $abilityCategory->id;
$ability->save();
```

## Editing

Code example:
```php
$ability = Sentinel::findAbilityBySlug('viewroles');
// Same as:
//   $ability Sentinel::getAbilityRepository()->findBySlug('viewroles');
// Alternatively, if you know the ID/Name:
//   $$ability = Sentinel::findAbilityById(1);
//   $$ability = Sentinel::findAbilityByName('View Roles');

$ability->name = 'View Groups';
$ability->save();
```

## Deleting

Code example:
```php
$ability = Sentinel::findAbilityBySlug('viewroles');
$ability->delete();
```

# Ability Categories

## Listing

Code example:
```php
$abilityCategories = Sentinel::getAbilityCategoryRepository()->orderBy('name', 'ASC')->get();
```

## Creating

Code example:
```php
$abilityCategory = Sentinel::getAbilityCategoryRepository()->createModel();
$abilityCategory->name = 'Roles';
$abilityCategory->save();
```

## Editing

Code example:
```php
$abilityCategory = Sentinel::findAbilityCategoryByName('Roles');
// Same as:
//   $ability Sentinel::getAbilityCategoryRepository()->findByName('Roles');
// Alternatively, if you know the ID:
//   $abilityCategory = Sentinel::findAbilityCategoryById(1);
$abilityCategory->name = 'Groups';
$abilityCategory->save();
```

## Deleting

Code example:
```php
$abilityCategory = Sentinel::findAbilityCategoryByName('Roles');
$abilityCategory->delete();
```

## Changing an Ability's Category
```php
$abilityCategory = Sentinel::findAbilityCategoryByName('Groups');

$ability = Sentinel::findAbilityBySlug('viewroles');
$ability->ability_category_id = $abilityCategory->id;
$ability->save();
```