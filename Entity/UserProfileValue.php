<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

use CrisisTextLine\UserProfileBundle\Entity\UserProfile;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileField;

/**
 * @ORM\Entity(repositoryClass="CrisisTextLine\UserProfileBundle\Entity\Repository\UserProfileValueRepository")
 * @ORM\Table(name="user_profile_value")
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
     * @ORM\ManyToOne(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfile", inversedBy="values")
     * @ORM\JoinColumn(name="user_profile_id", referencedColumnName="id")
     */
    protected $userProfile;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfileField", inversedBy="values")
     * @ORM\JoinColumn(name="user_profile_field_id", referencedColumnName="id")
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
     * @ORM\Column(name="time_last_edited", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $timeLastEdited;


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
    public function setUserProfile(UserProfile $userProfile)
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
    public function setUserProfileField(UserProfileField $userProfileField)
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
     * Set timeLastEdited
     *
     * @param \DateTime $timeLastEdited
     * @return UserProfileValue
     */
    public function setTimeLastEdited($timeLastEdited)
    {
        $this->timeLastEdited = $timeLastEdited;

        return $this;
    }

    /**
     * Get timeLastEdited
     *
     * @return \DateTime 
     */
    public function getTimeLastEdited()
    {
        return $this->timeLastEdited;
    }
}
