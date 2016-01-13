<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use FOS\UserBundle\Model\UserInterface as BaseUserInterface;
use CrisisTextLine\UserProfileBundle\Model\UserProfileInterface;

interface UserInterface extends BaseUserInterface
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
