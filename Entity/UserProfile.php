<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\Column(name="time_created", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $timeCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time_last_edited", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $timeLastEdited;

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
     * Set timeCreated
     *
     * @param \DateTime $timeCreated
     * @return UserProfile
     */
    public function setTimeCreated($timeCreated)
    {
        $this->timeCreated = $timeCreated;

        return $this;
    }

    /**
     * Get timeCreated
     *
     * @return \DateTime 
     */
    public function getTimeCreated()
    {
        return $this->timeCreated;
    }

    /**
     * Set timeLastEdited
     *
     * @param \DateTime $timeLastEdited
     * @return UserProfile
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
