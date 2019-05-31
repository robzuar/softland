<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Client
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="client")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Client
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
    * @ORM\Column(name="cod_aux", type="string", length=255, nullable=true)
     */
    private $codAux;

    /**
     * @var string
     *
     * @ORM\Column(name="no_faux", type="string", length=15, nullable=true)
     */
    private $noFAux;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_aux", type="string", length=255, nullable=true)
     */
    private $nomAux;

    /**
     * @var string
     *
     * @ORM\Column(name="rut_aux", type="string", length=15, nullable=true)
     */
    private $rutAux;

    /**
     * @var string
     *
     * @ORM\Column(name="dirAux", type="string", length=255, nullable=true)
     */
    private $dirAux;

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
     * Client constructor.
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
        return $this->nomAux;
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
     * Set codAux.
     *
     * @param string $codAux
     *
     * @return Client
     */
    public function setCodAux($codAux = null)
    {
        $this->codAux = $codAux;

        return $this;
    }

    /**
     * Get codAux.
     *
     * @return string
     */
    public function getCodAux()
    {
        return $this->codAux;
    }

    /**
     * Set noFAux.
     *
     * @param string $noFAux
     *
     * @return Client
     */
    public function setNoFAux($noFAux = null)
    {
        $this->noFAux = $noFAux;

        return $this;
    }

    /**
     * Get noFAux.
     *
     * @return string
     */
    public function getNoFAux()
    {
        return $this->noFAux;
    }

    /**
     * Set nomAux.
     *
     * @param string $nomAux
     *
     * @return Client
     */
    public function setNomAux($nomAux = null)
    {
        $this->nomAux = $nomAux;

        return $this;
    }

    /**
     * Get nomAux.
     *
     * @return string
     */
    public function getNomAux()
    {
        return $this->nomAux;
    }

    /**
     * Set rutAux.
     *
     * @param string $rutAux
     *
     * @return Client
     */
    public function setRutAux($rutAux = null)
    {
        $this->rutAux = $rutAux;

        return $this;
    }

    /**
     * Get rutAux.
     *
     * @return string
     */
    public function getRutAux()
    {
        return $this->rutAux;
    }

    /**
     * Set dirAux.
     *
     * @param string $dirAux
     *
     * @return Client
     */
    public function setDirAux($dirAux = null)
    {
        $this->dirAux = $dirAux;

        return $this;
    }

    /**
     * Get dirAux.
     *
     * @return string
     */
    public function getDirAux()
    {
        return $this->dirAux;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Client
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
     * @return Client
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
     * @return Client
     */
    public function setCreatedBy(Usuario $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy.
     *
     * @return \AppBundle\Entity\Usuario|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
