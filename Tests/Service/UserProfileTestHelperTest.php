<?php

namespace CrisisTextLine\UserProfileBundle\Tests\Service;

use CrisisTextLine\UserProfileBundle\Component\UserProfileTestCase;

class UserProfileTestHelperTest extends UserProfileTestCase
{
    public function testSetupSectionsAndFields()
    {
        $testHelper = $this->get('crisistextline.service.user_profile_test_helper');
        $repos = $testHelper->getEntityRepos();

        $testHelper->setupSectionsAndFields();
        $sectionOne = $repos['section']->findOneByName('test-section-one');
        $sectionTwo = $repos['section']->findOneByName('test-section-two');

        // Testing numer of sections and fields
        $sections = $repos['section']->findAll();
        $this->assertEquals(2, count($sections));

        $fields = $repos['field']->findAll();
        $this->assertEquals(5, count($fields));

        // Testing number of fields per section
        $fieldsOne = $repos['field']->findBy(array('section' => $sectionOne));
        $this->assertEquals(3, count($fieldsOne));

        $fieldsTwo = $repos['field']->findBy(array('section' => $sectionTwo));
        $this->assertEquals(2, count($fieldsTwo));
    }
}
