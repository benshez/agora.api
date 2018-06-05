<?php

namespace Agora\Bundles\Contact\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Agora\Bundles\Entities\Entity\Entities;
use Agora\Bundles\Roles\Entity\Roles;
use Agora\Modules\Base\Traits\TimestampableTrait;
/**
 * Contact
 *
 * @ORM\Table(name="contact", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})}, indexes={@ORM\Index(name="idx_phone", columns={"phone"}), @ORM\Index(name="fk_contact_role_id_roles_id_idx", columns={"role_id"}), @ORM\Index(name="fk_contact_entity_id_entities_id_idx", columns={"entity_id"}), @ORM\Index(name="idx_token_char", columns={"token_char"})})
 * @ORM\Entity @HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Agora\Bundles\Contact\Entity\Repository")
 */
class Contact
{
    use TimestampableTrait;
    /**
    * @var integer
    *
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="IDENTITY")
    */
    private $id;

    /**
    * @var string
    *
    * @ORM\Column(name="username", type="string", length=255, nullable=false)
    */
    private $username;

    /**
    * @var string
    *
    * @ORM\Column(name="usersurname", type="string", length=255, nullable=false)
    */
    private $usersurname;

    /**
    * @var string
    *
    * @ORM\Column(name="password", type="string", length=255, nullable=false)
    */
    private $password;

    /**
    * @var integer
    *
    * @ORM\Column(name="retries", type="integer", length=11, nullable=true)
    */
    private $retries;

    /**
    * @var boolean
    *
    * @ORM\Column(name="enabled", type="boolean", nullable=true)
    */
    private $enabled;

    /**
    * @var boolean
    *
    * @ORM\Column(name="locked", type="boolean", nullable=false)
    */
    private $locked;

    /**
    * @var string
    *
    * @ORM\Column(name="address", type="text", length=65535, nullable=true)
    */
    private $address;

    /**
    * @var string
    *
    * @ORM\Column(name="city", type="string", length=40, nullable=true)
    */
    private $city;

    /**
    * @var string
    *
    * @ORM\Column(name="state", type="string", length=10, nullable=true)
    */
    private $state;

    /**
    * @var string
    *
    * @ORM\Column(name="post_code", type="string", length=10, nullable=false)
    */
    private $postCode;

    /**
    * @var string
    *
    * @ORM\Column(name="phone", type="string", length=28, nullable=true)
    */
    private $phone;

    /**
    * @var string
    *
    * @ORM\Column(name="email", type="string", length=28, nullable=false)
    */
    private $email;

    /**
    * @var string
    *
    * @ORM\Column(name="website", type="string", length=255, nullable=true)
    */
    private $website;

    /**
    * @var string
    *
    * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
    */
    private $facebook;

    /**
    * @var string
    *
    * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
    */
    private $twitter;

    /**
    * @var string
    *
    * @ORM\Column(name="token_char", type="string", length=16, nullable=true)
    */
    private $tokenChar;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="token_expiry", type="datetime", nullable=true)
    */
    private $tokenExpiry;

    /**
    * @var \DateTime
    *
    * @ORM\Column(name="last_login", type="datetime", nullable=true)
    */
    private $lastLogin;

    /**
    * @var string
    *
    * @ORM\Column(name="logo", type="string", length=255, nullable=true)
    */
    private $logo;

    /**
    * @var \Agora\Bundles\Entities\Entity\Entities
    *
    * @ORM\ManyToOne(targetEntity="\Agora\Bundles\Entities\Entity\Entities")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
    * })
    */
    private $entity;

    /**
    * @var \Roles
    *
    * @ORM\ManyToOne(targetEntity="\Agora\Bundles\Roles\Entity\Roles")
    * @ORM\JoinColumns({
    *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
    * })
    */
    private $role;

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
    * Set username
    *
    * @param string $username
    *
    * @return Contact
    */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
    * Get username
    *
    * @return string
    */
    public function getUsername()
    {
        return $this->username;
    }

    /**
    * Set usersurname
    *
    * @param string $usersurname
    *
    * @return Contact
    */
    public function setUsersurname($usersurname)
    {
        $this->usersurname = $usersurname;

        return $this;
    }

    /**
    * Get usersurname
    *
    * @return string
    */
    public function getUsersurname()
    {
        return $this->usersurname;
    }

    /**
    * Set password
    *
    * @param string $password
    *
    * @return Contact
    */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
    * Get password
    *
    * @return string
    */
    public function getPassword()
    {
        return $this->password;
    }

    /**
    * Set retries
    *
    * @param integer $retries
    *
    * @return Contact
    */
    public function setRetries($retries)
    {
        $this->retries = $retries;

        return $this;
    }

    /**
    * Get retries
    *
    * @return integer
    */
    public function getRetries()
    {
        return $this->retries;
    }

    /**
    * Set enabled
    *
    * @param boolean $enabled
    *
    * @return Contact
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
    * Set locked
    *
    * @param boolean $locked
    *
    * @return Contact
    */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
    * Get locked
    *
    * @return boolean
    */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
    * Set address
    *
    * @param string $address
    *
    * @return Contact
    */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
    * Get address
    *
    * @return string
    */
    public function getAddress()
    {
        return $this->address;
    }

    /**
    * Set city
    *
    * @param string $city
    *
    * @return Contact
    */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
    * Get city
    *
    * @return string
    */
    public function getCity()
    {
        return $this->city;
    }

    /**
    * Set state
    *
    * @param string $state
    *
    * @return Contact
    */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
    * Get state
    *
    * @return string
    */
    public function getState()
    {
        return $this->state;
    }

    /**
    * Set postCode
    *
    * @param string $postCode
    *
    * @return Contact
    */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
    * Get postCode
    *
    * @return string
    */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
    * Set phone
    *
    * @param string $phone
    *
    * @return Contact
    */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
    * Get phone
    *
    * @return string
    */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
    * Set email
    *
    * @param string $email
    *
    * @return Contact
    */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
    * Get email
    *
    * @return string
    */
    public function getEmail()
    {
        return $this->email;
    }

    /**
    * Set website
    *
    * @param string $website
    *
    * @return Contact
    */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
    * Get website
    *
    * @return string
    */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
    * Set facebook
    *
    * @param string $facebook
    *
    * @return Contact
    */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
    * Get facebook
    *
    * @return string
    */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
    * Set twitter
    *
    * @param string $twitter
    *
    * @return Contact
    */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
    * Get twitter
    *
    * @return string
    */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
    * Set tokenChar
    *
    * @param string $tokenChar
    *
    * @return Contact
    */
    public function setTokenChar($tokenChar)
    {
        $this->tokenChar = $tokenChar;

        return $this;
    }

    /**
    * Get tokenChar
    *
    * @return string
    */
    public function getTokenChar()
    {
        return $this->tokenChar;
    }

    /**
    * Set tokenExpiry
    *
    * @param \DateTime $tokenExpiry
    *
    * @return Contact
    */
    public function setTokenExpiry($tokenExpiry)
    {
        $this->tokenExpiry = $tokenExpiry;

        return $this;
    }

    /**
    * Get tokenExpiry
    *
    * @return \DateTime
    */
    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
    }

    /**
    * Set lastLogin
    *
    * @param \DateTime $lastLogin
    *
    * @return Contact
    */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
    * Get lastLogin
    *
    * @return \DateTime
    */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
    * Set logo
    *
    * @param string $logo
    *
    * @return Contact
    */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
    * Get logo
    *
    * @return string
    */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
    * Set updatedAt
    *
    * @param \DateTime $updatedAt
    *
    * @return Contact
    */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
    * Get updatedAt
    *
    * @return \DateTime
    */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
    * Set createdAt
    *
    * @param \DateTime $createdAt
    *
    * @return Contact
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
    * Set entity
    *
    * @param \Agora\Bundles\Entities\Entity\Entities $entity
    *
    * @return Contact
    */
    public function setEntity(Entities $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
    * Get entity
    *
    * @return \Entities
    */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
    * Set role
    *
    * @param \Roles $role
    *
    * @return Contact
    */
    public function setRole(Roles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
    * Get role
    *
    * @return \Roles
    */
    public function getRole()
    {
        return $this->role;
    }
}
