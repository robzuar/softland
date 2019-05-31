<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Dispatch
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="dispatch")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Dispatch
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_axd", type="string", nullable=true)
     */
    private $codAxd;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_dch", type="string", length=255, nullable=true)
     */
    private $nomDch;

    /**
     * @var string
     *
     * @ORM\Column(name="dir_dch", type="string", length=255, nullable=true)
     */
    private $dirDch;

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
     * Dispatch constructor.
     * @param $user
     * @throws \Exception
     */
    public function __construct($user)
    {
        $this->enabled = true;
        $this->createdBy = $user;
        $this->createdAt = new \DateTime();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nomDch;
    }


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codAxd.
     *
     * @param string $codAxd
     *
     * @return Dispatch
     */
    public function setCodAxd($codAxd = null)
    {
        $this->codAxd = $codAxd;

        return $this;
    }

    /**
     * Get codAxd.
     *
     * @return string
     */
    public function getCodAxd()
    {
        return $this->codAxd;
    }

    /**
     * Set nomDch.
     *
     * @param string $nomDch
     *
     * @return Dispatch
     */
    public function setNomDch($nomDch = null)
    {
        $this->nomDch = $nomDch;

        return $this;
    }

    /**
     * Get nomDch.
     *
     * @return string
     */
    public function getNomDch()
    {
        return $this->nomDch;
    }

    /**
     * Set dirDch.
     *
     * @param string $dirDch
     *
     * @return Dispatch
     */
    public function setDirDch($dirDch = null)
    {
        $this->dirDch = $dirDch;

        return $this;
    }

    /**
     * Get dirDch.
     *
     * @return string
     */
    public function getDirDch()
    {
        return $this->dirDch;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Dispatch
     */
    public function setEnabled($enabled = null)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return Dispatch
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdBy.
     *
     * @param Usuario|null $createdBy
     *
     * @return Dispatch
     */
    public function setCreatedBy(Usuario $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return Usuario|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
