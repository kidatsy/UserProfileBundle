<?php

namespace CrisisTextLine\UserProfileBundle\Tests\Service;

use CrisisTextLine\UserProfileBundle\Component\UserProfileTestCase;

class UserProfileManagerTest extends UserProfileTestCase
{
    public function testAccessRestrictions()
    {
        $testHelper = $this->get('crisistextline.service.user_profile_test_helper');
        $repos = $testHelper->getEntityRepos();

        $testHelper->setupSectionsAndFields();
        $fields = $repos['field']->findAll();

        $userAdmin = $this->createOrReturnUser('admin@test.com', true);
        $userUser = $this->createOrReturnUser('user@test.com', false);

        $profileManager = $this->get('crisistextline.service.user_profile_manager');
        foreach ($fields as $field) {
            $accessReadAdmin = $profileManager->checkFieldAccess('read', $field, $userAdmin);
            $accessReadUser = $profileManager->checkFieldAccess('read', $field, $userUser);
            $accessWriteAdmin = $profileManager->checkFieldAccess('write', $field, $userAdmin);
            $accessWriteUser = $profileManager->checkFieldAccess('write', $field, $userUser);

            switch($field->getName()) {
                case 'test-field-alpha':
                    // Both read and write are null, so permission should default to section
                    // In this case, section is also null, so all permissions should return true
                    $this->assertTrue($accessReadAdmin);
                    $this->assertTrue($accessReadUser);
                    $this->assertTrue($accessWriteAdmin);
                    $this->assertTrue($accessWriteUser);
                    break;
                case 'test-field-beta':
                    // Read access is granted only to superadmins
                    // Edit access should only be by superadmins too, then
                    $this->assertTrue($accessReadAdmin);
                    $this->assertFalse($accessReadUser);
                    $this->assertTrue($accessWriteAdmin);
                    $this->assertFalse($accessWriteUser);
                    break;
                case 'test-field-gamma':
                    // Edit access only restricted to superadmins
                    $this->assertTrue($accessReadAdmin);
                    $this->assertTrue($accessReadUser);
                    $this->assertTrue($accessWriteAdmin);
                    $this->assertFalse($accessWriteUser);
                    break;
                case 'test-field-delta':
                    // Read access is granted only to superadmins
                    // Edit access should only be by superadmins too, then
                    $this->assertTrue($accessReadAdmin);
                    $this->assertFalse($accessReadUser);
                    $this->assertTrue($accessWriteAdmin);
                    $this->assertFalse($accessWriteUser);
                    break;
                case 'test-field-epsilon':
                    // Both read and write are null, so permission should default to section
                    // In this case, section is set for superadmins, so should mirror delta
                    $this->assertTrue($accessReadAdmin);
                    $this->assertFalse($accessReadUser);
                    $this->assertTrue($accessWriteAdmin);
                    $this->assertFalse($accessWriteUser);
                    break;
            }
        }

    }
}
