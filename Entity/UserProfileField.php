<?php

namespace CrisisTextLine\UserProfileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

use CrisisTextLine\UserProfileBundle\CrisisTextLineUserProfileBundle;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileValue;
use CrisisTextLine\UserProfileBundle\Entity\UserProfileSection;

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
     * @ORM\Column(name="display_name", type="string", length=255)
     */
    protected $displayName;

    /**
     * @var string
     *
     * @ORM\Column(name="default_value", type="text", nullable=true)
     */
    protected $defaultValue = null;

    /**
     * @var integer
     *
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfileSection", inversedBy="fields")
     * @ORM\JoinColumn(name="user_profile_section_id", referencedColumnName="id")
     */
    protected $section;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", options={"default" = true})
     */
    private $enabled = true;

    /**
     * @var int
     *
     * @Gedmo\SortablePosition
     * @ORM\Column(name="weight", type="integer", options={"default" = 0})
     */
    private $weight = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", options={"default" = 1})
     */
    protected $type = 1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_list", type="boolean", options={"default" = false})
     */
    private $isList = false;

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
     * @ORM\OneToMany(targetEntity="\CrisisTextLine\UserProfileBundle\Entity\UserProfileValue", mappedBy="userProfileField")
     */
    protected $values;

    public function __construct(
        $weight = 0,
        $name = null,
        $displayName = null,
        $defaultValue = null,
        $section = null,
        $type = 1,
        $readAccess = null,
        $writeAccess = null,
        $enabled = true
    ) {
        $this->values = new ArrayCollection();
        $this->weight = $weight;
        $this->name = $name;
        $this->displayName = ($displayName == null) ? $name : $displayName;
        $this->defaultValue = $defaultValue;
        $this->section = $section;
        $this->type = $type;
        $this->readAccess = $readAccess;
        $this->writeAccess = $writeAccess;
        $this->enabled = $enabled;
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
     * Set displayName
     *
     * @param string $displayName
     * @return UserProfileField
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
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
     * Set section
     *
     * @param string $section
     * @return UserProfileField
     */
    public function setSection(UserProfileSection $section)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return string 
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return UserProfileSection
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
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
     * Set isList
     *
     * @param boolean $isList
     * @return UserProfileSection
     */
    public function setIsList($isList)
    {
        $this->isList = $isList;

        return $this;
    }

    /**
     * Get isList
     *
     * @return boolean
     */
    public function getIsList()
    {
        return $this->isList;
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
     * Get human-readable version of field type
     *
     * @return string 
     */
    public function getHumanReadableType()
    {
        return CrisisTextLineUserProfileBundle::getHumanReadableFieldTypes()[$this->type];
    }

    /**
     * Boolean for if field holds series data
     *
     * @return string
     */
    public function isSeries()
    {
        return ($this->type == CrisisTextLineUserProfileBundle::FIELD_TYPE_SERIES);
    }

    /**
     * Return array of profile field for representation as JSON object
     *
     * @return array
     */
    public function getPreJSON()
    {
        return array(
            'id'            => $this->id,
            'name'          => $this->name,
            'displayName'   => $this->displayName,
            'weight'        => $this->weight,
            'defaultValue'  => $this->defaultValue,
            'section_id'    => $this->section->getId(),
            'type'          => $this->getHumanReadableType(),
            'isSeries'      => $this->isSeries(),
            'isList'        => $this->isList,
            'readAccess'    => $this->readAccess,
            'writeAccess'   => $this->writeAccess,
            'enabled'       => $this->enabled,
        );
    }
}
