[![CircleCI](https://circleci.com/gh/deltoss/sentinel-database-permissions.svg?style=svg)](https://circleci.com/gh/deltoss/sentinel-database-permissions)

# Introduction
A [Laravel](https://github.com/laravel/laravel) package that configures Sentinel to use database permissions. [Cartalyst Sentinel](https://cartalyst.com/manual/sentinel/2.0) already has permissions, however their permissions are JSON values stored under the user or role record.

Some would prefer permissions to be a database table, to perform certain operations more efficiently when it comes to permissions. For example lets say we want to get a list of all permissions in the database.

In Cartalyst Sentinel, to get all permissions, you'd need to iterate through __all__ users and roles, and for each of the user/role, you'd need to get their list of permissions and get only the distinct permissions. If you have a lot of users and roles, this approach won't be efficient. If you put permissions on a database table, then all you need to do is query that one table.

This package integrates with Sentinel and add its own set of methods. This means for the most part, you can use the Sentinel's API as per normal. The only caveat is before adding permissions, you'll need to create the `ability` on the database beforehand.

# Requirements
* Laravel Framework 5.5+
* Cartalyst Sentinel 2.0+
* php 7.1.3+

# Documentation
The project documentation can be found in the repo's [GitHub pages](https://deltoss.github.io/sentinel-database-permissions/)