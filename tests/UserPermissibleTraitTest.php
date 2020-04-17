<?php

namespace Deltoss\SentinelDatabasePermissions\Tests;

use Sentinel;

class UserPermissibleTraitTest extends DatabaseTestCase
{
    public function testAddUserPermissions()
    {
        $user = $this->registerUser();
        $abilityCategory = $this->createAbilityCategory();
        [$createUserAbility, $viewUserAbility, $updateUserAbility, $deleteUserAbility] = $this->createAbilities($abilityCategory);

        $user->addPermission($createUserAbility, true);
        $user->addPermission($viewUserAbility->id, true);
        $user->addPermission('updateusers', true);
        $user->addPermission('deleteusers', false);
        
        // Assertions to test if the permissable object properties were updated
        $this->assertEquals($user->getAbilities()->where('slug', 'createusers')->first()->id, $createUserAbility->id);
        $this->assertEquals($user->getAbilities()->where('slug', 'viewusers')->first()->id, $viewUserAbility->id);
        $this->assertEquals($user->getAbilities()->where('slug', 'updateusers')->first()->id, $updateUserAbility->id);
        $this->assertEquals($user->getAbilities()->where('slug', 'deleteusers')->first()->id, $deleteUserAbility->id);

        // Assertions to test if the permissions were added to database
        $this->assertEquals($user->abilities()->where('slug', 'createusers')->first()->id, $createUserAbility->id);
        $this->assertEquals($user->abilities()->where('slug', 'viewusers')->first()->id, $viewUserAbility->id);
        $this->assertEquals($user->abilities()->where('slug', 'updateusers')->first()->id, $updateUserAbility->id);
        $this->assertEquals($user->abilities()->where('slug', 'deleteusers')->first()->id, $deleteUserAbility->id);

        // Assertions to test if Sentinel detects that it has the correctly configured access
        $this->assertTrue($user->hasAccess('createusers'));
        $this->assertTrue($user->hasAccess('viewusers'));
        $this->assertTrue($user->hasAccess('updateusers'));
        $this->assertFalse($user->hasAccess('deleteusers'));

        // Assertions to test if the number of abilities is correct
        $this->assertCount(4, $user->abilities);
    }

    public function testUpdateUserPermissions()
    {
        $user = $this->registerUser();
        $abilityCategory = $this->createAbilityCategory();
        [$createUserAbility] = $this->createAbilities($abilityCategory);

        $user->addPermission($createUserAbility, true);
        $user->updatePermission($createUserAbility, false);

        $this->assertFalse($user->hasAccess('createusers'));
    }

    public function testDeleteUserPermissions()
    {
        $user = $this->registerUser();
        $abilityCategory = $this->createAbilityCategory();
        [$createUserAbility, $viewUserAbility, $updateUserAbility, $deleteUserAbility] = $this->createAbilities($abilityCategory);

        $user->addPermission($createUserAbility, true);
        $user->addPermission($viewUserAbility, true);
        $user->addPermission($updateUserAbility, true);
        $user->addPermission($deleteUserAbility, true);

        $user->removePermission($createUserAbility);
        $user->removePermission($viewUserAbility->id);
        $user->removePermission('updateusers');
        $user->removePermission('deleteusers');
        
        // Assertions to test if permissable object no longer has any permissions
        $this->assertCount(0, $user->permissions);
        $this->assertCount(0, $user->abilities);
        // Assertions to test if user object no longer has access
        $this->assertFalse($user->hasAccess('createusers'));
        $this->assertFalse($user->hasAccess('viewusers'));
        $this->assertFalse($user->hasAccess('updateusers'));
        $this->assertFalse($user->hasAccess('deleteusers'));
    }

    public function testUpdateOrCreatePermission()
    {
        $user = $this->registerUser();
        $abilityCategory = $this->createAbilityCategory();

        [$createUserAbility, $viewUserAbility] = $this->createAbilities($abilityCategory);

        $user->addPermission('viewusers');
        $user->updatePermission('createusers', false);
        $this->assertCount(1, $user->getPermissions());
        $this->assertEquals('viewusers', $user->getPermissions()[0]->slug);
        $this->assertEquals(1, $user->getPermissions()[0]->permission->allowed);

        $user->updatePermission('createusers', false, true);
        $this->assertCount(2, $user->getPermissions());
        $this->assertEquals('createusers', $user->getPermissions()[1]->slug);
        $this->assertEquals(0, $user->getPermissions()[1]->permission->allowed);
    }

    public function testPermissionsSetterAndGetter()
    {
        $user = $this->registerUser();
        $abilityCategory = $this->createAbilityCategory();
        [$createUserAbility, $viewUserAbility, $updateUserAbility, $deleteUserAbility] = $this->createAbilities($abilityCategory);
        
        // Via slugs
        $user->setPermissions([
            'createusers',
            'viewusers' => false,
            'updateusers' => true,
            'deleteusers',
        ]);
        $this->assertTrue($user->hasAccess('createusers'));
        $this->assertFalse($user->hasAccess('viewusers'));
        $this->assertTrue($user->hasAccess('updateusers'));
        $this->assertTrue($user->hasAccess('deleteusers'));
        
        // Via IDs
        $user->setPermissions([
            $createUserAbility->id => false,
            $viewUserAbility->id => true,
            $updateUserAbility->id,
            $deleteUserAbility->id
        ]);
        $this->assertFalse($user->hasAccess('createusers'));
        $this->assertTrue($user->hasAccess('viewusers'));
        $this->assertTrue($user->hasAccess('updateusers'));
        $this->assertTrue($user->hasAccess('deleteusers'));

        // Via Objects
        $user->setPermissions([
            $createUserAbility,
            $viewUserAbility,
            $updateUserAbility,
            $deleteUserAbility
        ]);
        $this->assertTrue($user->hasAccess('createusers'));
        $this->assertTrue($user->hasAccess('viewusers'));
        $this->assertTrue($user->hasAccess('updateusers'));
        $this->assertTrue($user->hasAccess('deleteusers'));

        // Clear permissions
        $user->setPermissions([]);
        $this->assertCount(0, $user->permissions);
    }

    protected function registerUser()
    {
        return Sentinel::register([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'johndoe@example.com'
        ]);
    }

    protected function createAbilityCategory()
    {
        $abilityCategory = Sentinel::getAbilityCategoryRepository()->createModel();
        $abilityCategory->name = 'Users';
        $abilityCategory->save();
        return $abilityCategory;
    }

    protected function createAbilities($abilityCategory = null)
    {
        $abilityCategoryId = $abilityCategory ? $abilityCategory->getAbilityCategoryId() : null;

        $createUserAbility = Sentinel::getAbilityRepository()->createModel();
        $createUserAbility->name = 'Create Users';
        $createUserAbility->slug = 'createusers';
        $createUserAbility->ability_category_id = $abilityCategoryId;
        $createUserAbility->save();

        $viewUserAbility = Sentinel::getAbilityRepository()->createModel();
        $viewUserAbility->name = 'View Users';
        $viewUserAbility->slug = 'viewusers';
        $viewUserAbility->ability_category_id = $abilityCategoryId;
        $viewUserAbility->save();

        $updateUserAbility = Sentinel::getAbilityRepository()->createModel();
        $updateUserAbility->name = 'Update Users';
        $updateUserAbility->slug = 'updateusers';
        $updateUserAbility->ability_category_id = $abilityCategoryId;
        $updateUserAbility->save();

        $deleteUserAbility = Sentinel::getAbilityRepository()->createModel();
        $deleteUserAbility->name = 'Delete Users';
        $deleteUserAbility->slug = 'deleteusers';
        $deleteUserAbility->ability_category_id = $abilityCategoryId;
        $deleteUserAbility->save();

        return [$createUserAbility, $viewUserAbility, $updateUserAbility, $deleteUserAbility];
    }
}