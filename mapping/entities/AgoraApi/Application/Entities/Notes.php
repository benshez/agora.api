<?php

namespace AgoraApi\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notes
 *
 * @ORM\Table(name="notes", indexes={@ORM\Index(name="fk_contact_id_contact_id_idx_idx", columns={"contact_id"}), @ORM\Index(name="fk_added_by_contact_id_contact_id_idx_idx", columns={"added_by_contact_id"})})
 * @ORM\Entity
 */
class Notes
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
     * @var string
     *
     * @ORM\Column(name="note", type="blob", length=65535, nullable=false)
     */
    private $note;

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
     *   @ORM\JoinColumn(name="added_by_contact_id", referencedColumnName="id")
     * })
     */
    private $addedByContact;

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
     * Set note.
     *
     * @param string $note
     *
     * @return Notes
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note.
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Notes
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
     * @return Notes
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
     * Set addedByContact.
     *
     * @param \AgoraApi\Application\Entities\Contact|null $addedByContact
     *
     * @return Notes
     */
    public function setAddedByContact(\AgoraApi\Application\Entities\Contact $addedByContact = null)
    {
        $this->addedByContact = $addedByContact;

        return $this;
    }

    /**
     * Get addedByContact.
     *
     * @return \AgoraApi\Application\Entities\Contact|null
     */
    public function getAddedByContact()
    {
        return $this->addedByContact;
    }

    /**
     * Set contact.
     *
     * @param \AgoraApi\Application\Entities\Contact|null $contact
     *
     * @return Notes
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
