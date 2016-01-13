<?php

namespace CrisisTextLine\UserProfileBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
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
     * @ORM\Column(name="read_access", type="string", length=255)
     */
    protected $readAccess;

    /**
     * @var string
     *
     * @ORM\Column(name="write_access", type="string", length=255)
     */
    protected $writeAccess;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     */
    protected $type;


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
}
