<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class UserProfileValue
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_profile_id", type="integer")
     */
    protected $userProfile;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_profile_field_id", type="integer")
     */
    protected $userProfileField;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    protected $value;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    protected $timestamp;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userProfile
     *
     * @param integer $userProfile
     * @return UserProfileValue
     */
    public function setUserProfile($userProfile)
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * Get userProfile
     *
     * @return integer 
     */
    public function getUserProfile()
    {
        return $this->userProfile;
    }

    /**
     * Set userProfileField
     *
     * @param integer $userProfileField
     * @return UserProfileValue
     */
    public function setUserProfileField($userProfileField)
    {
        $this->userProfileField = $userProfileField;

        return $this;
    }

    /**
     * Get userProfileField
     *
     * @return integer 
     */
    public function getUserProfileField()
    {
        return $this->userProfileField;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return UserProfileValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return UserProfileValue
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
