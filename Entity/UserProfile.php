<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
// use FOS\UserBundle\Model\User;
use CrisisTextLine\UserProfileBundle\Entity\User;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;

/**
 * @ORM\Entity(repositoryClass="CrisisTextLine\UserProfileBundle\Entity\Repository\UserProfileRepository")
 * @ORM\Table(name="user_profile")
 */
class UserProfile
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
     * @ORM\OneToMany(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfileValue", mappedBy="userProfile")
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
