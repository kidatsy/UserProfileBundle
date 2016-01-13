<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use CrisisTextLine\UserProfile\Model\UserProfileInterface;

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
     * @ORM\Column(name="user_profile_id", type="integer", nullable=true)
     * @ORM\OneToOne(targetEntity="\CrisisTextLine\UserProfile\Model\UserProfileInterface", inversedBy="user")
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
    public function setUserProfile(UserProfileInterface $userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }
}
