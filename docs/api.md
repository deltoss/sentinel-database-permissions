# Notes
The below documentation only includes additional methods introduced by the package, and does not include core methods which Sentinel already has.

# \Deltoss\SentinelDatabasePermissions\ExtendedSentinel
---
## findAbilityById($id)
Returns an ability given an id.

* **Type:** 
  `static`
  
* **Parameters:** 
  `id=[integer]`

* **Returns:**
  `\Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  ```
---

## findAbilityBySlug($slug)
Returns an ability given a slug.

* **Type:** 
  `static`
  
* **Parameters:** 
  `slug=[string]`

* **Returns:**
  `\Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityBySlug('viewrole');
  ```
---

## findAbilityByName($name)
Returns an ability given a name.

* **Type:** 
  `static`
  
* **Parameters:** 
  `name=[string]`

* **Returns:**
  `\Deltoss\SentinelDatabasePermissions\Abilities\AbilityInterface`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityByName('View Role');
  ```
---

## findAbilityCategoryById($id)
Returns an ability category given an id.

* **Type:** 
  `static`
  
* **Parameters:** 
  `id=[integer]`

* **Returns:**
  `\Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface`

* **Sample Usage:**
  ```php
  $abilityCategory = Sentinel::findAbilityCategoryById(1);
  ```
---

## findAbilityCategoryByName($name)
Returns an ability given a name.

* **Type:** 
  `static`
  
* **Parameters:** 
  `name=[string]`

* **Returns:**
  `\Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface`

* **Sample Usage:**
  ```php
  $abilityCategory = Sentinel::findAbilityCategoryByName('Roles');
  ```
---

## getAbilities()
Gets the assigned abilities of the current logged-in user. This does not include abilities through roles.

* **Type:** 
  `static`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $userAbilities = Sentinel::getAbilities();
  ```
---

## getAllowedAbilities()
Gets the assigned allowed abilities of the current logged-in user. This does not include abilities through roles.

* **Type:** 
  `static`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $userAbilities = Sentinel::getAllowedAbilities();
  ```
---

## getRejectedAbilities()
Gets the assigned rejected abilities of the current logged-in user. This does not include abilities through roles.

* **Type:** 
  `static`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $userAbilities = Sentinel::getRejectedAbilities();
  ```
---

## getAllAbilities()
Gets the directly and indirectly assigned abilities of the current logged-in user. This includes abilities through roles.

* **Type:** 
  `static`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $userAbilities = Sentinel::getAllAbilities();
  ```
---

## getAllAllowedAbilities()
Gets the directly and indirectly assigned allowed abilities of the current logged-in user. This includes abilities through roles.

* **Type:** 
  `static`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $userAbilities = Sentinel::getAllAllowedAbilities();
  ```
---

## getAllRejectedAbilities()
Gets the directly and indirectly assigned rejected abilities of the current logged-in user. This includes abilities through roles.

* **Type:** 
  `static`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $userAbilities = Sentinel::getAllRejectedAbilities();
  ```
---

# \Deltoss\SentinelDatabasePermissions\Users\ExtendedUser
---
## abilities()
The associated abilities that the user has, regardless whether the permission was denied/allowed.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Database\Eloquent\Relations\BelongsToMany`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->abilities;
  // OR with querying
  // $abilities = $user->abilities()->orderBy('name')->get();
  ```
---

## getAbilities()
The associated abilities that the user has, regardless whether the permission was denied/allowed. This does not include abilities through roles.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->getAbilities();
  ```
---

## getAllowedAbilities()
The allowed abilities that the user has. This does not include abilities through roles.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->getAllowedAbilities();
  ```
---

## getRejectedAbilities()
The rejected abilities that the user has. This does not include abilities through roles.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->getRejectedAbilities();
  ```
---

## getAllAbilities()
Get all abilities for the user. This includes abilities through roles.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->getAllAbilities();
  ```
---

## getAllAllowedAbilities()
The allowed abilities that the user has. This includes abilities through roles.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->getAllAllowedAbilities();
  ```
---

## getAllRejectedAbilities()
The allowed abilities that the user has. This includes abilities through roles.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $user = Sentinel::findUserById(1);
  $abilities = $user->getAllRejectedAbilities();
  ```
---

# \Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole
---
## abilities()
The associated abilities that the role has, regardless whether the permission was denied/allowed.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Database\Eloquent\Relations\BelongsToMany`

* **Sample Usage:**
  ```php
  $role = Sentinel::findRoleById(1);
  $abilities = $role->abilities;
  // OR with querying
  // $abilities = $role->abilities()->orderBy('name')->get();
  ```
---

## getAbilities()
The associated abilities that the role has, regardless whether the permission was denied/allowed.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $role = Sentinel::findRoleById(1);
  $abilities = $role->getAbilities();
  ```
---

# \Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility
---
| Property      | Type          | Description                           |
| ------------- | ------------- | ------------------------------------- |
| id            | int           | The unique identifier and primary key.|
| name          | string        | The displayed name.                   |
| slug          | string        | A unique slug string.                 |
---
## getAbilityId()
Returns the ability's primary key.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `int`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $id = $ability->getAbilityId();
  ```
---

## getAbilitySlug()
Returns the ability's slug.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `string`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $id = $ability->getAbilitySlug();
  ```
---

## getAbilityCategory()
Returns the ability's category.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Deltoss\SentinelDatabasePermissions\AbilityCategories\AbilityCategoryInterface`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $abilityCategory = $ability->getAbilityCategory();
  ```
---

## getRoles()
Returns all roles for the ability.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $roles = $ability->getRoles();
  ```
---

## getUsers()
Returns all directly associated users for the ability.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $users = $ability->getUsers();
  ```
---

## getAllUsers()
Returns all directly and indirectly (e.g. via roles) associated users for the ability.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $users = $ability->getAllUsers();
  ```
---

## getAllAllowedUsers()
Returns all directly and indirectly (e.g. via roles) associated users that has allowed access for the ability.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $users = $ability->getAllAllowedUsers();
  ```
---

## getAllRejectedUsers()
Returns all directly and indirectly (e.g. via roles) associated users that has rejected access for the ability.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $ability = Sentinel::findAbilityById(1);
  $users = $ability->getAllRejectedUsers();
  ```
---

# \Deltoss\SentinelDatabasePermissions\AbilityCategories\EloquentAbilityCategory
---
| Property      | Type          | Description                           |
| ------------- | ------------- | ------------------------------------- |
| id            | int           | The unique identifier and primary key.|
| name          | string        | The displayed name.                   |
---

## getAbilityCategoryId()
Returns the ability category's primary key.
* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `int`

* **Sample Usage:**
  ```php
  $abilityCategory = Sentinel::findAbilityCategoryById(1);
  $id = $abilityCategory->getAbilityCategoryId();
  ```
---

## abilities()
The abilities grouped under the ability category.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Database\Eloquent\Relations\BelongsToMany`

* **Sample Usage:**
  ```php
  abilityCategory = Sentinel::findAbilityCategoryById(1);
  $abilities = abilityCategory->abilities;
  // OR with querying
  // $abilities = abilityCategory->abilities()->orderBy('name')->get();
  ```
---

## getAbilities()
The abilities grouped under the ability category.

* **Type:** 
  `instance`
  
* **Parameters:** 
  `none`

* **Returns:**
  `\Illuminate\Support\Collection`

* **Sample Usage:**
  ```php
  $abilityCategory = Sentinel::findAbilityCategoryById(1);
  $abilities = $abilityCategory->getAbilities();
  ```
---