<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class BillControl
 *
 * @package AppBundle/Entity
 *
 * @ORM\Table(name="billControl")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BillControlRepository")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillControl
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
     * @ORM\Column(name="received_at", type="date",nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="mount", type="integer", nullable=true)
     */
    private $mount;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="string", length=255, nullable=true)
     */
    private $comment;

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
     * @ORM\OneToOne(targetEntity="BillLine")
     * @ORM\JoinColumn(name="billLine", referencedColumnName="id")
     */
    private $billLine;

    /**
     * @ORM\ManyToOne(targetEntity="Bill")
     * @ORM\JoinColumn(name="bill", referencedColumnName="id")
     */
    private $bill;

    /**
     * @Assert\NotBlank(message="not_blank")
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeComplaint")
     * @ORM\JoinColumn(name="type_complaint", referencedColumnName="id")
     */
    private $typeComplaint;

    /**
     * @ORM\ManyToOne(targetEntity="Status")
     * @ORM\JoinColumn(name="status", referencedColumnName="id")
     */
    private $status;

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
     * BillControl constructor.
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set receivedAt.
     *
     * @param \DateTime|null $receivedAt
     *
     * @return BillControl
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

    /**
     * Set creditNote.
     *
     * @param string $creditNote
     *
     * @return BillControl
     */
    public function setCreditNote($creditNote = null)
    {
        $this->creditNote = $creditNote;

        return $this;
    }

    /**
     * Get creditNote.
     *
     * @return string
     */
    public function getCreditNote()
    {
        return $this->creditNote;
    }

    /**
     * Set discount.
     *
     * @param int $discount
     *
     * @return BillControl
     */
    public function setDiscount($discount = null)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount.
     *
     * @return int
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set mount.
     *
     * @param int $mount
     *
     * @return BillControl
     */
    public function setMount($mount = null)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * Get mount.
     *
     * @return int
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * Set comment.
     *
     * @param string $comment
     *
     * @return BillControl
     */
    public function setComment($comment = null)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set nsValue.
     *
     * @param int $nsValue
     *
     * @return BillControl
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
     * @return BillControl
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
     * @return BillControl
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
     * @return BillControl
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
     * Set billLine.
     *
     * @param BillLine|null $billLine
     *
     * @return BillControl
     */
    public function setBillLine(BillLine $billLine = null)
    {
        $this->billLine = $billLine;

        return $this;
    }

    /**
     * Get billLine.
     *
     * @return BillLine|null
     */
    public function getBillLine()
    {
        return $this->billLine;
    }
    /**
     * Set bill.
     *
     * @param Bill|null $bill
     *
     * @return BillControl
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
     * Set typeComplaint.
     *
     * @param TypeComplaint $typeComplaint
     *
     * @return BillControl
     */
    public function setTypeComplaint(TypeComplaint $typeComplaint = null)
    {
        $this->typeComplaint = $typeComplaint;

        return $this;
    }

    /**
     * Get typeComplaint.
     *
     * @return TypeComplaint
     */
    public function getTypeComplaint()
    {
        return $this->typeComplaint;
    }

    /**
     * Set status.
     *
     * @param Status|null $status
     *
     * @return BillControl
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
     * Set createdBy.
     *
     * @param Usuario|null $createdBy
     *
     * @return BillControl
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
