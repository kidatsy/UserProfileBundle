<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use Doctrine\ORM\Mapping as ORM;
use CrisisTextLine\UserProfileBundle\Model\UserInterface;
use CrisisTextLine\UserProfileBundle\Model\UserProfileValue;

/**
 * @ORM\MappedSuperclass
 */
class UserProfile implements UserProfileInterface
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
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\OneToOne(targetEntity="\CrisisTextLine\UserProfileBundle\Model\User", mappedBy="userProfile")
     */
    protected $user;

    /**
     * @ORM\OneToMany(targetEntity="\CrisisTextLine\UserProfileBundle\Model\UserProfileValue", mappedBy="userProfile")
     */
    protected $values;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    protected $timestamp;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

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
     * Set userId
     *
     * @param integer $user
     * @return UserProfileInterface
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add values
     *
     * @param UserProfileValue $values
     * @return UserProfile
     */
    public function addValue(UserProfileValue $values)
    {
        $this->values[] = $values;

        return $this;
    }

    /**
     * Remove values
     *
     * @param UserProfileValue $values
     */
    public function removeValue(UserProfileValue $values)
    {
        $this->values->removeElement($values);
    }

    /**
     * Get values
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return UserProfile
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
