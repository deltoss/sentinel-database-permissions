# Notes
The below documentation only includes additional methods introduced by the package, and does not include core methods which Sentinel already has.

# Table of Contents
- [\Deltoss\SentinelDatabasePermissions\ExtendedSentinel](#extended-sentinel)
  * [findAbilityById($id)](#extended-sentinel-findabilitybyid)
  * [findAbilityBySlug($slug)](#extended-sentinel-findabilitybyslug)
  * [findAbilityByName($name)](#extended-sentinel-findabilitybyname)
  * [findAbilityCategoryById($id)](#extended-sentinel-findabilitycategorybyid)
  * [findAbilityCategoryByName($name)](#extended-sentinel-findabilitycategorybyname)
  * [getAbilities()](#extended-sentinel-getabilities)
  * [getAllAbilities()](#extended-sentinel-getallabilities)
  * [getAllAllowedAbilities()](#extended-sentinel-getallallowedabilities)
  * [getAllRejectedAbilities()](#extended-sentinel-getallrejectedabilities)
- [\Deltoss\SentinelDatabasePermissions\Users\ExtendedUser](#extended-user)
  * [abilities()](#extended-user-abilities)
  * [getAbilities()](#extended-user-getabilities)
  * [getAllAbilities()](#extended-user-getallabilities)
  * [getAllAllowedAbilities()](#extended-user-getallallowedabilities)
  * [getAllRejectedAbilities()](#extended-user-getallrejectedabilities)
- [\Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole](#extended-role)
  * [abilities()](#extended-role-abilities)
  * [getAbilities()](#extended-role-getabilities)
- [\Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility](#eloquent-ability)
  * [getAbilityId()](#eloquent-ability-getabilityid)
  * [getAbilitySlug()](#eloquent-ability-getabilityslug)
  * [getAbilityCategory()](#eloquent-ability-getabilitycategory)
  * [getRoles()](#eloquent-ability-getroles)
  * [getUsers()](#eloquent-ability-getusers)
  * [getAllUsers()](#eloquent-ability-getallusers)
  * [getAllAllowedUsers()](#eloquent-ability-getallallowedusers)
  * [getAllRejectedUsers()](#eloquent-ability-getallrejectedusers)
- [\Deltoss\SentinelDatabasePermissions\AbilityCategories\EloquentAbilityCategory](#eloquent-ability-category)
  * [getAbilityCategoryId()](#eloquent-ability-category-getabilitycategoryid)
  * [abilities()](#eloquent-ability-category-abilities)
  * [getAbilities()](#eloquent-ability-category-getabilities)
---

# <a name="extended-sentinel"></a>\Deltoss\SentinelDatabasePermissions\ExtendedSentinel
---
## <a name="extended-sentinel-findabilitybyid"></a>findAbilityById($id)
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

## <a name="extended-sentinel-findabilitybyslug"></a>findAbilityBySlug($slug)
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

## <a name="extended-sentinel-findabilitybyname"></a>findAbilityByName($name)
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

## <a name="extended-sentinel-findabilitycategorybyid"></a>findAbilityCategoryById($id)
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

## <a name="extended-sentinel-findabilitycategorybyname"></a>findAbilityCategoryByName($name)
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

## <a name="extended-sentinel-getabilities"></a>getAbilities()
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

## <a name="extended-sentinel-getallowedabilities"></a>getAllowedAbilities()
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

## <a name="extended-sentinel-getrejectedabilities"></a>getRejectedAbilities()
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

## <a name="extended-sentinel-getallabilities"></a>getAllAbilities()
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

## <a name="extended-sentinel-getallallowedabilities"></a>getAllAllowedAbilities()
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

## <a name="extended-sentinel-getallrejectedabilities"></a>getAllRejectedAbilities()
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

# <a name="extended-user"></a>\Deltoss\SentinelDatabasePermissions\Users\ExtendedUser
---
## <a name="extended-user-abilities"></a>abilities()
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

## <a name="extended-user-getabilities"></a>getAbilities()
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

## <a name="extended-user-getallowedabilities"></a>getAllowedAbilities()
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

## <a name="extended-user-getrejectedabilities"></a>getRejectedAbilities()
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

## <a name="extended-user-getallabilities"></a>getAllAbilities()
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

## <a name="extended-user-getallallowedabilities"></a>getAllAllowedAbilities()
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

## <a name="extended-user-getallrejectedabilities"></a>getAllRejectedAbilities()
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

# <a name="extended-role"></a>\Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole
---
## <a name="extended-role-abilities"></a>abilities()
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

## <a name="extended-role-getabilities"></a>getAbilities()
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

# <a name="eloquent-ability"></a>\Deltoss\SentinelDatabasePermissions\Abilities\EloquentAbility
---
| Property      | Type          | Description                           |
| ------------- | ------------- | ------------------------------------- |
| id            | int           | The unique identifier and primary key.|
| name          | string        | The displayed name.                   |
| slug          | string        | A unique slug string.                 |
---
## <a name="eloquent-ability-getabilityid"></a>getAbilityId()
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

## <a name="eloquent-ability-getabilityslug"></a>getAbilitySlug()
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

## <a name="eloquent-ability-getabilitycategory"></a>getAbilityCategory()
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

## <a name="eloquent-ability-getroles"></a>getRoles()
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

## <a name="eloquent-ability-getusers"></a>getUsers()
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

## <a name="eloquent-ability-getallusers"></a>getAllUsers()
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

## <a name="eloquent-ability-getallallowedusers"></a>getAllAllowedUsers()
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

## <a name="eloquent-ability-getallrejectedusers"></a>getAllRejectedUsers()
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

# <a name="eloquent-ability-category"></a>\Deltoss\SentinelDatabasePermissions\AbilityCategories\EloquentAbilityCategory
---
| Property      | Type          | Description                           |
| ------------- | ------------- | ------------------------------------- |
| id            | int           | The unique identifier and primary key.|
| name          | string        | The displayed name.                   |
---

## <a name="eloquent-ability-category-getabilitycategoryid"></a>getAbilityCategoryId()
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

## <a name="eloquent-ability-category-abilities"></a>abilities()
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

## <a name="eloquent-ability-category-getabilities"></a>getAbilities()
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