<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use CrisisTextLine\UserProfileBundle\Model\UserInterface;

interface UserProfileInterface
{
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();

    /**
     * Set userId
     *
     * @param integer $user
     * @return UserProfile
     */
    public function setUser(UserInterface $user);

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser();

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return UserProfile
     */
    public function setTimestamp($timestamp);

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp();
}
