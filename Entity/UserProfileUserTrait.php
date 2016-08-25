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
     * @ORM\OneToOne(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfile", inversedBy="user", cascade={"persist"})
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
    public function setUserProfile($userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Return array of just profile data (minus user) for representation as JSON object
     *
     * @return array
     */
    public function getUserProfileDataArray()
    {
        if ($this->getUserProfile()) {
            return $this->userProfile->getDataArray();
        } else {
            return array();
        }
    }

    /**
     * Return array of user for representation as JSON object
     *
     * @return array
     */
    public function getPreJSON()
    {
        $returnArray = array(
            'id'                => $this->id,
            'username'          => $this->username,
            'email'             => $this->email,
        );

        return $returnArray;
    }
}
