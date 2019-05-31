<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BillLinea
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="billLinea")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillLine
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
     * @var integer
     *
     * @ORM\Column(name="nro_int", type="integer", nullable=true)
     */
    private $nroInt;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_prod", type="string", length=255, nullable=true)
     */
    private $codProd;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_aux", type="string", length=255, nullable=true)
     */
    private $codAux;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="linea", type="integer", nullable=true)
     */
    private $linea;

    /**
     * @var string
     *
     * @ORM\Column(name="det_prod", type="string", length=255, nullable=true)
     */
    private $detProd;

    /**
     * @var string
     *
     * @ORM\Column(name="code_umed", type="string", length=255, nullable=true)
     */
    private $codeUMed;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_facturada", type="integer", nullable=true)
     */
    private $cantFacturada;

    /**
     * @var string
     *
     * @ORM\Column(name="pre_uni_mb", type="string", length=255, nullable=true)
     */
    private $preUniMB;

    /**
     * @var integer
     *
     * @ORM\Column(name="cant_fact_uvta", type="integer", nullable=true)
     */
    private $cantFactUVta;

    /**
     * @var integer
     *
     * @ORM\Column(name="tot_linea", type="integer", nullable=true)
     */
    private $totLinea;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Bill")
     * @ORM\JoinColumn(name="bill", referencedColumnName="id")
     */
    private $bill;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Product")
     * @ORM\JoinColumn(name="product", referencedColumnName="id")
     */
    private $product;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="ns_value_control", type="integer", nullable=true)
     */
    private $nsValueControl;

    /**
     * @var integer
     *
     * @ORM\Column(name="percentage_control", type="integer", nullable=true)
     */
    private $percentageControl;

    /**
     * @var integer
     *
     * @ORM\Column(name="ns_value_complaint", type="integer", nullable=true)
     */
    private $nsValueComplaint;

    /**
     * @var integer
     *
     * @ORM\Column(name="percentage_complaint", type="integer", nullable=true)
     */
    private $percentageComplaint;
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
     * BillLine constructor.
     * @param $user
     * @param $status
     * @throws \Exception
     */
    public function __construct($user, $status)
    {
        $this->enabled = true;
        $this->status = $status;
        $this->createdBy = $user;
        $this->createdAt = new \DateTime();
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
     * Set nroInt.
     *
     * @param int $nroInt
     *
     * @return BillLine
     */
    public function setNroInt($nroInt = null)
    {
        $this->nroInt = $nroInt;

        return $this;
    }

    /**
     * Get nroInt.
     *
     * @return int
     */
    public function getNroInt()
    {
        return $this->nroInt;
    }

    /**
     * Set codProd.
     *
     * @param string $codProd
     *
     * @return BillLine
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
     * Set codAux.
     *
     * @param string $codAux
     *
     * @return BillLine
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
     * Set fecha.
     *
     * @param \DateTime|null $fecha
     *
     * @return BillLine
     */
    public function setFecha($fecha = null)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha.
     *
     * @return \DateTime|null
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set linea.
     *
     * @param int $linea
     *
     * @return BillLine
     */
    public function setLinea($linea = null)
    {
        $this->linea = $linea;

        return $this;
    }

    /**
     * Get linea.
     *
     * @return int
     */
    public function getLinea()
    {
        return $this->linea;
    }

    /**
     * Set detProd.
     *
     * @param string $detProd
     *
     * @return BillLine
     */
    public function setDetProd($detProd = null)
    {
        $this->detProd = $detProd;

        return $this;
    }

    /**
     * Get detProd.
     *
     * @return string
     */
    public function getDetProd()
    {
        return $this->detProd;
    }

    /**
     * Set codeUMed.
     *
     * @param string $codeUMed
     *
     * @return BillLine
     */
    public function setCodeUMed($codeUMed = null)
    {
        $this->codeUMed = $codeUMed;

        return $this;
    }

    /**
     * Get codeUMed.
     *
     * @return string
     */
    public function getCodeUMed()
    {
        return $this->codeUMed;
    }

    /**
     * Set cantFacturada.
     *
     * @param int $cantFacturada
     *
     * @return BillLine
     */
    public function setCantFacturada($cantFacturada = null)
    {
        $this->cantFacturada = $cantFacturada;

        return $this;
    }

    /**
     * Get cantFacturada.
     *
     * @return int
     */
    public function getCantFacturada()
    {
        return $this->cantFacturada;
    }

    /**
     * Set preUniMB.
     *
     * @param string $preUniMB
     *
     * @return BillLine
     */
    public function setPreUniMB($preUniMB = null)
    {
        $this->preUniMB = $preUniMB;

        return $this;
    }

    /**
     * Get preUniMB.
     *
     * @return string
     */
    public function getPreUniMB()
    {
        return $this->preUniMB;
    }

    /**
     * Set cantFactUVta.
     *
     * @param int $cantFactUVta
     *
     * @return BillLine
     */
    public function setCantFactUVta($cantFactUVta = null)
    {
        $this->cantFactUVta = $cantFactUVta;

        return $this;
    }

    /**
     * Get cantFactUVta.
     *
     * @return int
     */
    public function getCantFactUVta()
    {
        return $this->cantFactUVta;
    }

    /**
     * Set totLinea.
     *
     * @param int $totLinea
     *
     * @return BillLine
     */
    public function setTotLinea($totLinea = null)
    {
        $this->totLinea = $totLinea;

        return $this;
    }

    /**
     * Get totLinea.
     *
     * @return int
     */
    public function getTotLinea()
    {
        return $this->totLinea;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return BillLine
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
     * Set nsValueControl.
     *
     * @param int $nsValueControl
     *
     * @return BillLine
     */
    public function setNsValueControl($nsValueControl = null)
    {
        $this->nsValueControl = $nsValueControl;

        return $this;
    }

    /**
     * Get nsValueControl.
     *
     * @return int
     */
    public function getNsValueControl()
    {
        return $this->nsValueControl;
    }

    /**
     * Set percentageControl.
     *
     * @param int $percentageControl
     *
     * @return BillLine
     */
    public function setPercentageControl($percentageControl = null)
    {
        $this->percentageControl = $percentageControl;

        return $this;
    }

    /**
     * Get percentageControl.
     *
     * @return int
     */
    public function getPercentageControl()
    {
        return $this->percentageControl;
    }

    /**
     * Set nsValueComplaint.
     *
     * @param int $nsValueComplaint
     *
     * @return BillLine
     */
    public function setNsValueComplaint($nsValueComplaint = null)
    {
        $this->nsValueComplaint = $nsValueComplaint;

        return $this;
    }

    /**
     * Get nsValueComplaint.
     *
     * @return int
     */
    public function getNsValueComplaint()
    {
        return $this->nsValueComplaint;
    }

    /**
     * Set percentageComplaint.
     *
     * @param int $percentageComplaint
     *
     * @return BillLine
     */
    public function setPercentageComplaint($percentageComplaint = null)
    {
        $this->percentageComplaint = $percentageComplaint;

        return $this;
    }

    /**
     * Get percentageComplaint.
     *
     * @return int
     */
    public function getPercentageComplaint()
    {
        return $this->percentageComplaint;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return BillLine
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
     * Set status.
     *
     * @param Status|null $status
     *
     * @return BillLine
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return Status|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set bill.
     *
     * @param Bill|null $bill
     *
     * @return BillLine
     */
    public function setBill(Bill $bill = null)
    {
        $this->bill = $bill;

        return $this;
    }

    /**
     * Get bill.
     *
     * @return Bill|null
     */
    public function getBill()
    {
        return $this->bill;
    }

    /**
     * Set product
     *
     * @param Product|null $product
     *
     * @return BillLine
     */
    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product.
     *
     * @return Product|null
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set createdBy.
     *
     * @param Usuario|null $createdBy
     *
     * @return BillLine
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
