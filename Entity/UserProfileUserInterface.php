<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;

interface UserProfileUserInterface
{
    /**
     * @param UserProfile $userProfile
     */
    public function setUserProfile($userProfile);

    /**
     * @return UserProfile
     */
    public function getUserProfile();

    /**
     * @return array
     */
    public function getUserProfileDataArray();

    /**
     * @return array
     */
    public function getPreJSON();
}
