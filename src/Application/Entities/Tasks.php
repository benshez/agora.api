<?php

namespace AgoraApi\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tasks
 *
 * @ORM\Table(name="tasks", indexes={@ORM\Index(name="fk_contact_id_contact_id_idx_idx_idx", columns={"contact_id"}), @ORM\Index(name="fk_assigned_contact_id_contact_id_idx_idx_idx", columns={"assigned_contact_id"})})
 * @ORM\Entity
 */
class Tasks
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status_id", type="integer", nullable=false)
     */
    private $statusId;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=255, nullable=false)
     */
    private $description;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_due", type="datetime", nullable=true)
     */
    private $dateDue;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_completed", type="datetime", nullable=true)
     */
    private $dateCompleted;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \AgoraApi\Application\Entities\Contact
     *
     * @ORM\ManyToOne(targetEntity="AgoraApi\Application\Entities\Contact")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="assigned_contact_id", referencedColumnName="id")
     * })
     */
    private $assignedContact;

    /**
     * @var \AgoraApi\Application\Entities\Contact
     *
     * @ORM\ManyToOne(targetEntity="AgoraApi\Application\Entities\Contact")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="contact_id", referencedColumnName="id")
     * })
     */
    private $contact;


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
     * Set statusId.
     *
     * @param int $statusId
     *
     * @return Tasks
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId.
     *
     * @return int
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Tasks
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDue.
     *
     * @param \DateTime|null $dateDue
     *
     * @return Tasks
     */
    public function setDateDue($dateDue = null)
    {
        $this->dateDue = $dateDue;

        return $this;
    }

    /**
     * Get dateDue.
     *
     * @return \DateTime|null
     */
    public function getDateDue()
    {
        return $this->dateDue;
    }

    /**
     * Set dateCompleted.
     *
     * @param \DateTime|null $dateCompleted
     *
     * @return Tasks
     */
    public function setDateCompleted($dateCompleted = null)
    {
        $this->dateCompleted = $dateCompleted;

        return $this;
    }

    /**
     * Get dateCompleted.
     *
     * @return \DateTime|null
     */
    public function getDateCompleted()
    {
        return $this->dateCompleted;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Tasks
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Tasks
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set assignedContact.
     *
     * @param \AgoraApi\Application\Entities\Contact|null $assignedContact
     *
     * @return Tasks
     */
    public function setAssignedContact(\AgoraApi\Application\Entities\Contact $assignedContact = null)
    {
        $this->assignedContact = $assignedContact;

        return $this;
    }

    /**
     * Get assignedContact.
     *
     * @return \AgoraApi\Application\Entities\Contact|null
     */
    public function getAssignedContact()
    {
        return $this->assignedContact;
    }

    /**
     * Set contact.
     *
     * @param \AgoraApi\Application\Entities\Contact|null $contact
     *
     * @return Tasks
     */
    public function setContact(\AgoraApi\Application\Entities\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return \AgoraApi\Application\Entities\Contact|null
     */
    public function getContact()
    {
        return $this->contact;
    }
}
