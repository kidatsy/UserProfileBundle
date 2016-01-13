<?php

namespace CrisisTextLine\UserProfileBundle\Model;

interface UserProfileFieldInterface
{
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId();

    /**
     * Set name
     *
     * @param string $name
     * @return UserProfileField
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string 
     */
    public function getName();

    /**
     * Set readAccess
     *
     * @param string $readAccess
     * @return UserProfileField
     */
    public function setReadAccess($readAccess);

    /**
     * Get readAccess
     *
     * @return string 
     */
    public function getReadAccess();

    /**
     * Set writeAccess
     *
     * @param string $writeAccess
     * @return UserProfileField
     */
    public function setWriteAccess($writeAccess);

    /**
     * Get writeAccess
     *
     * @return string 
     */
    public function getWriteAccess();

    /**
     * Set type
     *
     * @param integer $type
     * @return UserProfileField
     */
    public function setType($type);

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType();
}
