<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;

/**
 * @ORM\Entity(repositoryClass="CrisisTextLine\UserProfileBundle\Entity\Repository\UserProfileFieldRepository")
 * @ORM\Table(name="user_profile_field")
 */
class UserProfileField
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    protected $name;

    /**
     * @var string
     *
     * @ORM\Column(name="default_value", type="text", nullable=true)
     */
    protected $defaultValue = null;

    /**
     * @var string
     *
     * @ORM\Column(name="read_access", type="string", length=255, nullable=true)
     */
    protected $readAccess = null;

    /**
     * @var string
     *
     * @ORM\Column(name="write_access", type="string", length=255, nullable=true)
     */
    protected $writeAccess = null;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", options={"default" = 1})
     */
    protected $type = 1;

    /**
     * @ORM\OneToMany(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfileValue", mappedBy="userProfileField")
     */
    protected $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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
     * Set name
     *
     * @param string $name
     * @return UserProfileField
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set defaultValue
     *
     * @param string $defaultValue
     * @return UserProfileField
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    /**
     * Get defaultValue
     *
     * @return string 
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * Set readAccess
     *
     * @param string $readAccess
     * @return UserProfileField
     */
    public function setReadAccess($readAccess)
    {
        $this->readAccess = $readAccess;

        return $this;
    }

    /**
     * Get readAccess
     *
     * @return string 
     */
    public function getReadAccess()
    {
        return $this->readAccess;
    }

    /**
     * Set writeAccess
     *
     * @param string $writeAccess
     * @return UserProfileField
     */
    public function setWriteAccess($writeAccess)
    {
        $this->writeAccess = $writeAccess;

        return $this;
    }

    /**
     * Get writeAccess
     *
     * @return string 
     */
    public function getWriteAccess()
    {
        return $this->writeAccess;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return UserProfileField
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
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
}
