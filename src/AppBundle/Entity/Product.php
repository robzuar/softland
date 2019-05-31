<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Product
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="product")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Product
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
     * @ORM\Column(name="cod_prod", type="string", length=255, nullable=true)
     */
    private $codProd;

    /**
     * @var string
     *
     * @ORM\Column(name="des_prod", type="text", nullable=true)
     */
    private $desProd;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_umed", type="string", length=255, nullable=true)
     */
    private $codUMed;

    /**
     * @var float
     *
     * @ORM\Column(name="precio_vta", type="float", nullable=true)
     */
    private $precioVta;
    
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
     * Product constructor.
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
        return $this->desProd;
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
     * Set codProd.
     *
     * @param string $codProd
     *
     * @return Product
     */
    public function setCodProd($codProd = null)
    {
        $this->codProd = $codProd;

        return $this;
    }

    /**
     * Get codProd.
     *
     * @return string
     */
    public function getCodProd()
    {
        return $this->codProd;
    }

    /**
     * Set desProd.
     *
     * @param string $desProd
     *
     * @return Product
     */
    public function setDesProd($desProd = null)
    {
        $this->desProd = $desProd;

        return $this;
    }

    /**
     * Get desProd.
     *
     * @return string
     */
    public function getDesProd()
    {
        return $this->desProd;
    }

    /**
     * Set codUMed.
     *
     * @param string $codUMed
     *
     * @return Product
     */
    public function setCodUMed($codUMed = null)
    {
        $this->codUMed = $codUMed;

        return $this;
    }

    /**
     * Get codUMed.
     *
     * @return string
     */
    public function getCodUMed()
    {
        return $this->codUMed;
    }

    /**
     * Set precioVta.
     *
     * @param float|null $precioVta
     *
     * @return Product
     */
    public function setPrecioVta($precioVta = null)
    {
        $this->precioVta = $precioVta;

        return $this;
    }

    /**
     * Get precioVta.
     *
     * @return float|null
     */
    public function getPrecioVta()
    {
        return $this->precioVta;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Product
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
     * @return Product
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
     * @return Product
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
