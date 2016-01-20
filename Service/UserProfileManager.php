<?php

namespace CrisisTextLine\UserProfileBundle\Service;

use Doctrine\ORM\EntityManager;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;

/**
 * service_id: crisistextline.user_profile_manager
 */
class UserProfileManager
{
    /**
     * The entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Constructor.
     */
    public function __construct (
        EntityManager $em
    ) {
        $this->em = $em;
    }

    public function createUserProfile($user)
    {
        $userProfile = $user->getUserProfile();
        if ($userProfile == null || $userProfile->getUser() !== $user) {
            $userProfile = new UserProfile();
            $userProfile->setUser($user);
            $user->setUserProfile($userProfile);
            $this->em->persist($userProfile);
            $this->em->persist($user);
            $this->em->flush();
        }

        $this->attachMissingUserProfileValues($userProfile);

        return $userProfile;
    }

    /**
     * Blah
     *
     */
    public function attachMissingUserProfileValues(UserProfile $userProfile)
    {
        $fields = $this->em->getRepository('CrisisTextLineUserProfileBundle:UserProfileField')
            ->findAll();

        foreach ($fields as $field) {
            if (!$userProfile->getValueForField($field)) {
                $value = new UserProfileValue($userProfile, $field);
                $default = $field->getDefaultValue();
                if ($default !== null) {
                    $value->setValue($default);
                }
                $this->em->persist($value);                
            }
        }
        $this->em->flush();
    }
}