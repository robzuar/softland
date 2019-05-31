<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Route
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="route")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Route
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
     * @var int
     *
     * @ORM\Column(name="number", type="integer", nullable=true)
     */
    private $number;

    /**
     * @var string
     *
/**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;
/**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    private $route;
    
  /**
     * @var string
     *
     * @ORM\Column(name="route_alt", type="string", length=255, nullable=true)
     */
    private $routeAlt;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dispatch")
     * @ORM\JoinColumn(name="dispatch", referencedColumnName="id")
     */
    private $dispatch;

    /**
     * @var string
     *
     * @ORM\Column(name="day", type="string", length=255, nullable=true)
     */
    private $day;

    /**
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumn(name="region", referencedColumnName="id")
     */
    private $region;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime",nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id")
     */
    private $createdBy;


    /**
     * Route constructor.
     * @param $user
     * @throws \Exception
     */
    public function __construct($user)
    {
        $this->createdBy = $user;
        $this->createdAt = new \DateTime();
        $this->enabled = true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->number;
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
     * Set number
     *
     * @param string $number
     * @return Route
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Route
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
     * Set route
     *
     * @param string $route
     * @return Route
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set routeAlt
     *
     * @param string $routeAlt
     * @return Route
     */
    public function setRouteAlt($routeAlt)
    {
        $this->routeAlt = $routeAlt;

        return $this;
    }

    /**
     * Get routeAlt
     *
     * @return string
     */
    public function getRouteAlt()
    {
        return $this->routeAlt;
    }


    /**
     * Set address
     *
     * @param string $address
     * @return Route
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set dispatch
     *
     * @param Dispatch $dispatch
     *
     * @return Route
     */
    public function setDispatch(Dispatch $dispatch = null)
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    /**
     * Get dispatch
     *
     * @return Dispatch
     */
    public function getDispatch()
    {
        return $this->dispatch;
    }

    /**
     * Set day
     *
     * @param string $day
     * @return Route
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Route
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
     * Set region
     *
     * @param Region $region
     *
     * @return Route
     */
    public function setRegion(Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Route
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
     * @return Route
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
