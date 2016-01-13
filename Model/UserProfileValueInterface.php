<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use CrisisTextLine\UserProfileBundle\Model\UserProfileInterface;
use CrisisTextLine\UserProfileBundle\Model\UserProfileFieldInterface;

interface UserProfileValueInterface
{
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();

    /**
     * Set userProfile
     *
     * @param integer $userProfile
     * @return UserProfileValue
     */
    public function setUserProfile(UserProfileInterface $userProfile);

    /**
     * Get userProfile
     *
     * @return integer 
     */
    public function getUserProfile();

    /**
     * Set userProfileField
     *
     * @param integer $userProfileField
     * @return UserProfileValue
     */
    public function setUserProfileField(UserProfileFieldInterface $userProfileField);

    /**
     * Get userProfileField
     *
     * @return integer 
     */
    public function getUserProfileField();

    /**
     * Set value
     *
     * @param string $value
     * @return UserProfileValue
     */
    public function setValue($value);

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue();

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return UserProfileValue
     */
    public function setTimestamp($timestamp);

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp();
}
