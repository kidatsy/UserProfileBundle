<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

use CrisisTextLine\UserProfileBundle\Entity\UserProfileField;

/**
 * @ORM\Entity(repositoryClass="CrisisTextLine\UserProfileBundle\Entity\Repository\UserProfileSectionRepository")
 * @ORM\Table(name="user_profile_section")
 */
class UserProfileSection
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var int
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="weight", type="integer", options={"default" = 0})
     */
    private $weight = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="accessLevel", type="string", length=255, nullable=true)
     */
    private $accessLevel;

    /**
     * @ORM\OneToMany(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfileField", mappedBy="section")
     * @ORM\OrderBy({"weight"="ASC"})
     */
    private $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
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
     * @return UserProfileSection
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
     * Set description
     *
     * @param string $description
     * @return UserProfileSection
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return UserProfileSection
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set accessLevel
     *
     * @param string $accessLevel
     * @return UserProfileSection
     */
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get accessLevel
     *
     * @return string 
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Add fields
     *
     * @param UserProfileField $fields
     * @return UserProfileSection
     */
    public function addField(UserProfileField $fields)
    {
        $this->fields[] = $fields;

        return $this;
    }

    /**
     * Remove fields
     *
     * @param UserProfileField $fields
     */
    public function removeField(UserProfileField $fields)
    {
        $this->fields->removeElement($fields);
    }

    /**
     * Get fields
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFields()
    {
        return $this->fields;
    }
}
