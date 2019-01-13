<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Deltoss\SentinelDatabasePermissions\Users\ExtendedUser;
use Sentinel;

class UserTest extends DatabaseTestCase
{
    public function testRegister()
    {
        $user = Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);

        $userInDb = Sentinel::getUserRepository()->where('first_name', 'John')->where('last_name', 'Doe')->first();
        $this->assertEquals($user->id, $userInDb->id);
    }

    public function testExtendedUserModel()
    {
        // For this test, note we configured
        // the user model to be the ExtendedUser
        // instead of the default Sentinel's
        // user model within the DatabaseTestCase
        // class, inside the getEnvironmentSetUp()
        // method.
        
        $user = Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);
        $this->assertInstanceOf(ExtendedUser::class, $user);
    }
}