<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use FOS\UserBundle\Model\UserInterface as BaseFOSUserInterface;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileInterface;

interface UserInterface extends BaseFOSUserInterface
{
    /**
     * Get the user's User Profile
     *
     * @return UserProfile
     */
    public function getUserProfile();

    /**
     * Set the authentication code for this current login attempt
     *
     * @param UserProfile $userProfile
     */
    public function setUserProfile(UserProfileInterface $userProfile);

}
