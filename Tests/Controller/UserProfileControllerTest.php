<?php

namespace CrisisTextLine\UserProfileBundle\Tests\Controller;

use CrisisTextLine\UserProfileBundle\Component\UserProfileTestCase;

class UserProfileControllerTest extends UserProfileTestCase
{
    public function testAutoMakeProfile()
    {
        $testHelper = $this->get('crisistextline.service.user_profile_test_helper');
        $repos = $testHelper->getEntityRepos();

        $this->logIn($this->client);

        $user = $this->createOrReturnUser('dummy@test.com');
        $id = $user->getId();

        // Assert no existing profile
        $profile = $repos['profile']->findByUserId($id);
        if ($profile) {
            $user->setUserProfile(null);
            $this->em->persist($user);
            $this->em->flush();

            $this->em->remove($profile);
            $this->em->flush();
        }
        $profile = $repos['profile']->findByUserId($id);
        $this->assertFalse($profile);

        // Go to the profile page
        $crawler = $this->client->request('GET', '/user/' . $id . '/profile');

        // Check that it exists
        $profile = $repos['profile']->findByUserId($id);
        $this->assertTrue($profile->getId() !== null);

        // Check that it has the requisite values for existing fields
        $fields = $repos['field']->findAll();

        foreach ($fields as $field) {
            $this->assertTrue($profile->hasValueForField($field));
            if (($default = $field->getDefaultValue()) !== null) {
                $this->assertEquals($profile->getValueForField($field)->getValue(), $default);
            }
        }
    }
}
