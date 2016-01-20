<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;

interface UserProfileUserInterface
{
    /**
     * @param UserProfile $userProfile
     */
    public function setUserProfile(UserProfile $userProfile);

    /**
     * @return UserProfile
     */
    public function getUserProfile();
}