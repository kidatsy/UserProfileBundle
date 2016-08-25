<?php

namespace CrisisTextLine\UserProfileBundle\Service;

use Doctrine\ORM\EntityManager;

use CrisisTextLine\UserProfileBundle\CrisisTextLineUserProfileBundle;
use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileSection;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileField;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;

/**
 * service_id: crisistextline.service.user_profile_test_helper
 */
class UserProfileTestHelper
{
    protected $em;
    protected $repos;

    /**
     * Constructor.
     */
    public function __construct (
        EntityManager $em
    ) {
        $this->em = $em;
        $this->repos = $this->getEntityRepos();
    }

    public function getEntityRepos()
    {
        return array(
            'profile'   => $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfile'),
            'section'   => $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileSection'),
            'field'     => $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField'),
            'value'     => $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileValue'),
        );
    }

    /**
    * Gets or creates user profile, given user's ID
    *
    * @param integer $id ID
    *
    * @return UserProfile $profile
    */
    public function setupSectionsAndFields()
    {
        $sectionOne = $this->createOrReturnSection(
            'test-section-one',
            'Section One',
            'Descriptions are for wimps.',
            null
        );
        $sectionTwo = $this->createOrReturnSection(
            'test-section-two',
            'Section Two',
            'I told you, descriptions are for wimps.',
            'ROLE_SUPER_ADMIN'
        );

        $fieldOne = $this->createOrReturnField(
            'test-field-alpha',
            'Field Alpha',
            'I am the walrus.',
            $sectionOne,
            CrisisTextLineUserProfileBundle::FIELD_TYPE_TEXT,
            null,
            null
        );
        $fieldTwo = $this->createOrReturnField(
            'test-field-beta',
            null,
            null,
            $sectionOne,
            CrisisTextLineUserProfileBundle::FIELD_TYPE_TEXT,
            'ROLE_SUPER_ADMIN',
            null
        );
        $fieldThree = $this->createOrReturnField(
            'test-field-gamma',
            'Field Gamma',
            '["boards of canada", "bonobo", "mum"]',
            $sectionOne,
            CrisisTextLineUserProfileBundle::FIELD_TYPE_SERIES,
            null,
            'ROLE_SUPER_ADMIN'
        );
        $fieldFour = $this->createOrReturnField(
            'test-field-delta',
            'Field Delta',
            null,
            $sectionTwo,
            CrisisTextLineUserProfileBundle::FIELD_TYPE_BOOLEAN,
            'ROLE_SUPER_ADMIN',
            null
        );
        $fieldFive = $this->createOrReturnField(
            'test-field-epsilon',
            null,
            '["aphex twin", "squarepusher", "venetian snares"]',
            $sectionTwo,
            CrisisTextLineUserProfileBundle::FIELD_TYPE_SERIES,
            null,
            null
        );

    }

    public function createOrReturnSection(
        $name,
        $displayName = null,
        $description = null,
        $accessLevel = null
    ) {
        $return = $this->repos['section']->findBy(array('name' => $name));

        if ($return == null) {
            $currentHeaviest = intval($this->repos['section']->getHeaviestWeight());
            if ($displayName == null) $displayName = $name;

            $return = new UserProfileSection(
                $currentHeaviest + 1,
                $name,
                $displayName,
                $description,
                $accessLevel,
                true
            );
            $this->em->persist($return);
            $this->em->flush();
        }

        return $return;
    }

    public function createOrReturnField(
        $name,
        $displayName = null,
        $defaultValue = null,
        $section,
        $type = CrisisTextLineUserProfileBundle::FIELD_TYPE_TEXT,
        $readAccess = null,
        $writeAccess = null
    )
    {
        $return = $this->repos['field']->findBy(array('name' => $name));

        if ($return == null) {
            $currentHeaviest = intval($this->repos['field']->getHeaviestWeight());
            if ($displayName == null) $displayName = $name;

            $return = new UserProfileField(
                $currentHeaviest + 1,
                $name,
                $displayName,
                $defaultValue,
                $section,
                $type,
                $readAccess,
                $writeAccess,
                true
            );
            $this->em->persist($return);
            $this->em->flush();
        }

        return $return;
    }

    public function createOrReturnValue($profile, $field, $value)
    {
        $return = $this->repos['value']->findBy(array('userProfile' => $profile, 'userProfileField' => $field));

        if ($return == null) {
            $return = new UserProfileValue($profile, $field, $value);
            $this->em->persist($return);
            $this->em->flush();
        }

        return $return;
    }
}
