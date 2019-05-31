<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Vehicle
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="vehicle")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Vehicle
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
     * @ORM\Column(name="patent", type="string", length=7, nullable=true)
     * @Assert\Length(min=6, max=7)
     */
    private $patent;

    /**
     * @ORM\ManyToOne(targetEntity="Owner")
     * @ORM\JoinColumn(name="owner", referencedColumnName="id")
     */
    private $owner;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity="Bill", mappedBy="vehicle")
     */
    private $bills;

    /**
     * @ORM\OneToMany(targetEntity="Route", mappedBy="vehicle")
     */
    private $routes;

    /**
     * Vehicle constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->enabled = true;
        $this->createdBy = $user;
        $this->createdAt = new \DateTime();
        $this->routes = new ArrayCollection();
        $this->bills = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->patent;
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
     * Set patent
     *
     * @param string $patent
     * @return Vehicle
     */
    public function setPatent($patent)
    {
        $this->patent = $patent;

        return $this;
    }

    /**
     * Get patent
     *
     * @return string
     */
    public function getPatent()
    {
        return $this->patent;
    }

    /**
     * Set owner
     *
     * @param Owner $owner
     *
     * @return Vehicle
     */
    public function setOwner(Owner $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return Owner
     */
    public function getOwner()
    {
        return $this->owner;
    }


    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Vehicle
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Vehicle
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy
     *
     * @param Usuario $createdBy
     *
     * @return Vehicle
     */
    public function setCreatedby(Usuario $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return Usuario
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }


}
