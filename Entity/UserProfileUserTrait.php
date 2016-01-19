<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;

/**
 * For use with your user class, add this trait.
 */
trait UserProfileUserTrait
{
    /**
     * Profile for this user
     *
     * @var int
     *
     * @ORM\OneToOne(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfile", inversedBy="user")
     * @ORM\JoinColumn(name="user_profile_id", referencedColumnName="id")
     */
    protected $userProfile;

    /**
     * Get the user's User Profile
     *
     * @return UserProfile
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set the authentication code for this current login attempt
     *
     * @param UserProfile $userProfile
     */
    public function setUserProfile(UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }
}
