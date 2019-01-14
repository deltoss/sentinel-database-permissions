[![CircleCI](https://circleci.com/gh/deltoss/sentinel-database-permissions.svg?style=svg)](https://circleci.com/gh/deltoss/sentinel-database-permissions)

# Table of Contents
- [Introduction](#introduction)
- [Requirements](#requirements)
- [Concepts](#concepts)
  * [Abilities](#concepts-abilities)
  * [Permissions](#concepts-permissions)
  * [Ability Categories](#concepts-ability-categories)
- [Quick Start with New Laravel App](#quick-start-with-new-laravel-app)
- [Usage](#usage)
- [Extending Sentinel Database Permissions](#extending-sentinel-database-permissions)
  * [Models](#models)
  * [Migrations](#migrations)

# <a name="introduction"></a>Introduction
A [Laravel](https://github.com/laravel/laravel) package that configures Sentinel to use database permissions. [Cartalyst Sentinel](https://cartalyst.com/manual/sentinel/2.0) already has permissions, however their permissions are JSON values stored under the user or role record.

Some would prefer permissions to be a database table, to perform certain operations more efficiently when it comes to permissions. For example lets say we want to get a list of all permissions in the database.

In Cartalyst Sentinel, to get all permissions, you'd need to iterate through __all__ users and roles,and for each of the user/role, you'd need to get their list of permissions and get only the distinct permissions. If you have a lot of users and roles, this approach won't be efficient. If you put permissions on a database table, then all you need to do is query that one table.

This package integrates with Sentinel and add its own set of methods. This means for the most part, you can use the Sentinel's API as per normal. The only caveat is before adding permissions, you'll need to create the `ability` on the database beforehand.

# <a name="requirements"></a>Requirements
* Laravel Framework 5.5+
* Cartalyst Sentinel 2.0+
* php 7.1.3+

# <a name="concepts"></a>Concepts

## <a name="concepts-abilities"></a>Abilities
**Abilities** defines the list of actions that can be done for your system. For example, "View Roles", "Edit Roles" would be a set of abilities.

## <a name="concepts-permissions"></a>Permissions
**Permissions** defines the relationship between the permissable entity (roles or users) and the abilities, whether the permissable entity is allowed/denied access to perform an ability.

For example, given we have user A, we assign user A to have the ability of "View Roles" with "allow" access, and then we assign user A to have the ability of "Edit Roles" with "denied" access. By doing this, we can say user A has permissions to view roles, but has explicitly denied permissions to edit roles.

You should use the permissions entity if you're checking whether the abilities was directly allowed/denied for a given user/role.

E.g:
```php
$user = Sentinel::findUserById(1);
$abilities = $user->getAbilities();
foreach ($abilities as $ability)
{
    $permission = $ability->permission;    
    if ($permission->allowed)
    {
        // ... Do something
    }
}
```

Note if you a checking whether a user has a permission to do an action (i.e. ability), it's more reliable and easier to use the Sentinel `hasAccess` or `hasAnyAccess` method.

## <a name="concepts-ability-categories"></a>Ability Categories
**Ability categories** is just a grouping construct for abilities. For the process of authorisation, it's not relevant. It's there so when you display a list of permissions, e.g for a particular user, you can render them in groups.


# <a name="quick-start-with-new-laravel-app"></a>Quick Start with New Laravel App
**Install the package using composer**

```shell
$ composer require deltoss/sentinel-database-permissions
```

**If you haven't done so already, publish the Sentinel files (migration and configuration files)**
```shell
$ php artisan vendor:publish --provider='Cartalyst\Sentinel\Laravel\SentinelServiceProvider'
```

**Modify your `config/cartalyst.sentinel.php` file to be wired up to the extended models. The final config file should contain something similar to the below content**
```php
return [
    // ...
    'users' => [

        'model' => 'Deltoss\SentinelDatabasePermissions\Users\ExtendedUser',

    ],
    'roles' => [

        'model' => 'Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole',

    ],
    'permissions' => [

        'class' => 'Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions',

    ],
    // ...
]
```

**Run your database migrations**
```shell
$ php artisan migrate
```

# <a name="usage"></a>Usage

For the usage documentation, refer to [this](USAGE.md) link.

For the full API documentation, refer to [this](API.md) link.

# <a name="extending-sentinel-database-permissions"></a>Extending Sentinel Database Permissions

## <a name="models"></a>Models

Just like Sentinel, you can extend the models to fit your requirements. Just inherit from the below Models, and register them to your `config/cartalyst.sentinel.php` file. For more information, refer to [Extending Sentinel](https://github.com/cartalyst/sentinel/wiki/Extending-Sentinel)

* __Deltoss\SentinelDatabasePermissions\Users\ExtendedUser__
* __Deltoss\SentinelDatabasePermissions\Roles\ExtendedRole__
* __Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStandardPermissions__
* __Deltoss\SentinelDatabasePermissions\Permissions\ExtendedStrictPermissions__

To extend the new models introduced in Sentinel Database Permissions (listed below), the steps are the same as above, however you'd need to publish and modify the `config/sentinel.database.permissions.php` file instead.

* __Deltoss\SentinelDatabasePermissions\Ability\EloquentAbility__
* __Deltoss\SentinelDatabasePermissions\AbilityCategory\EloquentAbilityCategory__

To publish only the `config/sentinel.database.permissions.php` file, you can use below command:
```shell
$ php artisan vendor:publish --provider='Deltoss\SentinelDatabasePermissions\Providers\SentinelDatabasePermissionsServiceProvider' --tag=config
```

## <a name="migrations"></a>Migrations
It's completely optional to publish the migrations. You should only publish them if you'd need to modify them. However, generally it's a better idea to make your own additional migration files to make modifications to **Sentinel** or **Sentinel Database Permissions**.

```shell
$ php artisan vendor:publish --provider='Deltoss\SentinelDatabasePermissions\Providers\SentinelDatabasePermissionsServiceProvider' --tag=migrations
```