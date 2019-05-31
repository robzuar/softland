<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class TypeComplaint
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="typeComplaint")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class TypeComplaint
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_discount", type="boolean", nullable=true)
     */
    private $isDiscount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;



    /**
     * TypeComplaint constructor.
     */
    public function __construct()
    {
        $this->enabled = true;
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
     * @return TypeComplaint
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
     * @return string
     */
    public function __toString()
    {
        if($this->enabled == true ) {
            return 'Activo';
        }else{
            return 'No Activo';
        }
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return TypeComplaint
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
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return TypeComplaint
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
     * Set isDiscount
     *
     * @param boolean $isDiscount
     *
     * @return TypeComplaint
     */
    public function setIsDiscount($isDiscount)
    {
        $this->isDiscount = $isDiscount;

        return $this;
    }

    /**
     * Get isDiscount
     *
     * @return boolean
     */
    public function getIsDiscount()
    {
        return $this->isDiscount;
    }
}
