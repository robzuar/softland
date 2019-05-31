<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Complaint
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="complaint")
 * @ORM\Entity()
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class Complaint
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
     * @var \DateTime
     *
     * @ORM\Column(name="received_at", type="datetime", nullable=true)
     */
    private $receivedAt;

    /**
     * @var string
     * @Assert\NotBlank(message="not_blank")
     *
     * @ORM\Column(name="credit_note", type="string", length=255, nullable=true)
     */
    private $creditNote;


    /**
     * @var integer
     * @Assert\NotBlank(message="not_blank")
     *
     * @ORM\Column(name="discount", type="integer", nullable=true)
     */
    private $discount;

    /**
     * @ORM\OneToOne(targetEntity="BillLine")
     * @ORM\JoinColumn(name="billLine", referencedColumnName="id")
     */
    private $billLine;

    /**
     * @Assert\NotBlank(message="not_blank")
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeComplaint")
     * @ORM\JoinColumn(name="type_complaint", referencedColumnName="id")
     */
    private $typeComplaint;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    private $status;

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
     * Complaint constructor.
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set receivedAt
     *
     * @param \DateTime $receivedAt
     *
     * @return Complaint
     */
    public function setReceivedAt($receivedAt)
    {
        $this->receivedAt = $receivedAt;

        return $this;
    }

    /**
     * Get receivedAt
     *
     * @return \DateTime
     */
    public function getReceivedAt()
    {
        return $this->receivedAt;
    }

    /**
     * Set creditNote
     *
     * @param string $creditNote
     *
     * @return Complaint
     */
    public function setCreditNote($creditNote)
    {
        $this->creditNote = $creditNote;

        return $this;
    }

    /**
     * Get creditNote
     *
     * @return string
     */
    public function getCreditNote()
    {
        return $this->creditNote;
    }

    /**
     * Set discount
     *
     * @param integer $discount
     *
     * @return Complaint
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     *
     * @return integer
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Complaint
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
     * Set comment
     *
     * @param string $comment
     * @return Complaint
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set billLine
     *
     * @param BillLine $billLine
     *
     * @return Complaint
     */
    public function setBillLine(BillLine $billLine = null)
    {
        $this->billLine = $billLine;

        return $this;
    }

    /**
     * Get billLine
     *
     * @return BillLine
     */
    public function getBillLine()
    {
        return $this->billLine;
    }

    /**
     * Set typeComplaint
     *
     * @param TypeComplaint $typeComplaint
     *
     * @return Complaint
     */
    public function setTypeComplaint(TypeComplaint $typeComplaint = null)
    {
        $this->typeComplaint = $typeComplaint;

        return $this;
    }

    /**
     * Get typeComplaint
     *
     * @return TypeComplaint
     */
    public function getTypeComplaint()
    {
        return $this->typeComplaint;
    }

    /**
     * Set status
     *
     * @param Status $status
     *
     * @return Complaint
     */
    public function setStatus(Status $status = null)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return Status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set nsValue
     *
     * @param integer $nsValue
     *
     * @return Complaint
     */
    public function setNsValue($nsValue)
    {
        $this->nsValue = $nsValue;

        return $this;
    }

    /**
     * Get nsValue
     *
     * @return integer
     */
    public function getNsValue()
    {
        return $this->nsValue;
    }

    /**
     * Set percentage
     *
     * @param integer $percentage
     *
     * @return Complaint
     */
    public function setPercentage($percentage)
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * Get percentage
     *
     * @return integer
     */
    public function getPercentage()
    {
        return $this->percentage;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Complaint
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
     * @return Complaint
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
