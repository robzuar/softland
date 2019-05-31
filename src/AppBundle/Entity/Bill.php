<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Bill
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="bill")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BillRepository")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Bill
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
     * @var integer
     *
     * @ORM\Column(name="nv_numero", type="integer", nullable=true)
     */
    private $nvNumero;

    /**
     * @var integer
     *
     * @ORM\Column(name="folio", type="integer", nullable=true)
     */
    private $folio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="cod_aux", type="string", length=255, nullable=true)
     */
    private $codAux;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Dispatch")
     * @ORM\JoinColumn(name="dispatch", referencedColumnName="id")
     */
    private $dispatch;

    /**
     * @Assert\NotBlank(message="not_blank")
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle", inversedBy="bills")
     * @ORM\JoinColumn(name="vehicle", referencedColumnName="id")
     */
    private $vehicle;

    /**
     * @var integer
     *
     * @ORM\Column(name="ns_value", type="integer", nullable=true)
     */
    private $nsValue;

    /**
     * @var integer
     *
     * @ORM\Column(name="percentage", type="integer", nullable=true)
     */
    private $percentage;

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
     * @var integer
     *
     * @ORM\Column(name="total_lineas", type="integer", nullable=true)
     */
    private $totline;

    /**
     * @var integer
     *
     * @ORM\Column(name="total_parcial", type="integer", nullable=true)
     */
    private $totpar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="received_at", type="datetime", nullable=true)
     */
    private $receivedAt;

    /**
     * Bill constructor.
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
     * @return Bill
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
     * Set nvNumero.
     *
     * @param int $nvNumero
     *
     * @return Bill
     */
    public function setNvNumero($nvNumero = null)
    {
        $this->nvNumero = $nvNumero;

        return $this;
    }

    /**
     * Get nvNumero.
     *
     * @return int
     */
    public function getNvNumero()
    {
        return $this->nvNumero;
    }

    /**
     * Set folio.
     *
     * @param int $folio
     *
     * @return Bill
     */
    public function setFolio($folio = null)
    {
        $this->folio = $folio;

        return $this;
    }

    /**
     * Get folio.
     *
     * @return int
     */
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * Set fecha.
     *
     * @param \DateTime|null $fecha
     *
     * @return Bill
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
     * Set codAux.
     *
     * @param string $codAux
     *
     * @return Bill
     */
    public function setcodAux($codAux = null)
    {
        $this->codAux = $codAux;

        return $this;
    }

    /**
     * Get codAux.
     *
     * @return string
     */
    public function getcodAux()
    {
        return $this->codAux;
    }

    /**
     * Set nsValue.
     *
     * @param int $nsValue
     *
     * @return Bill
     */
    public function setNsValue($nsValue = null)
    {
        $this->nsValue = $nsValue;

        return $this;
    }

    /**
     * Get nsValue.
     *
     * @return int
     */
    public function getNsValue()
    {
        return $this->nsValue;
    }

    /**
     * Set percentage.
     *
     * @param int $percentage
     *
     * @return Bill
     */
    public function setPercentage($percentage = null)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage.
     *
     * @return int
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set enabled.
     *
     * @param bool $enabled
     *
     * @return Bill
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
     * @return Bill
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
     * @return Bill
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
     * Set client.
     *
     * @param Client|null $client
     *
     * @return Bill
     */
    public function setClient(Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client.
     *
     * @return Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set dispatch.
     *
     * @param Dispatch $dispatch
     *
     * @return Bill
     */
    public function setDispatch(Dispatch $dispatch = null)
    {
        $this->dispatch = $dispatch;

        return $this;
    }

    /**
     * Get dispatch.
     *
     * @return Dispatch
     */
    public function getDispatch()
    {
        return $this->dispatch;
    }

    /**
     * Set vehicle.
     *
     * @param Vehicle|null $vehicle
     *
     * @return Bill
     */
    public function setVehicle(Vehicle $vehicle = null)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * Get vehicle.
     *
     * @return Vehicle|null
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * Set createdBy.
     *
     * @param Usuario|null $createdBy
     *
     * @return Bill
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

    /**
     * Set totline.
     *
     * @param int $totline
     *
     * @return Bill
     */
    public function setTotline($totline = null)
    {
        $this->totline = $totline;

        return $this;
    }

    /**
     * Get totline.
     *
     * @return int
     */
    public function getTotline()
    {
        return $this->totline;
    }

    /**
     * Set totpar.
     *
     * @param int $totpar
     *
     * @return Bill
     */
    public function setTotpar($totpar = null)
    {
        $this->totpar = $totpar;

        return $this;
    }

    /**
     * Get totpar.
     *
     * @return int
     */
    public function getTotpar()
    {
        return $this->totpar;
    }
    /**
     * Set receivedAt.
     *
     * @param \DateTime|null $receivedAt
     *
     * @return Bill
     */
    public function setReceivedAt($receivedAt = null)
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    /**
     * Get receivedAt.
     *
     * @return \DateTime|null
     */
    public function getReceivedAt()
    {
        return $this->receivedAt;
    }

}
