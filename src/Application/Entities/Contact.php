<?php

/*
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

declare(strict_types=1);

namespace AgoraApi\Application\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contact.
 *
 * @ORM\Table(name="contact", uniqueConstraints={@ORM\UniqueConstraint(name="email_UNIQUE", columns={"email"})}, indexes={@ORM\Index(name="idx_phone", columns={"phone"}), @ORM\Index(name="fk_contact_role_id_roles_id_idx", columns={"role_id"}), @ORM\Index(name="fk_contact_entity_id_entities_id_idx", columns={"entity_id"}), @ORM\Index(name="idx_token_char", columns={"token_char"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AgoraApi\Application\Repositories\ContactRepository")
 */
class Contact
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
     * @var int|null
     *
     * @ORM\Column(name="retries", type="integer", nullable=true)
     */
    private $retries;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var bool
     *
     * @ORM\Column(name="locked", type="boolean", nullable=false)
     */
    private $locked;

    /**
     * @var string|null
     *
     * @ORM\Column(name="address", type="text", length=65535, nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city", type="string", length=40, nullable=true)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(name="state", type="string", length=10, nullable=true)
     */
    private $state;

    /**
     * @var string|null
     *
     * @ORM\Column(name="post_code", type="string", length=10, nullable=true)
     */
    private $postCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=28, nullable=true)
     */
    private $phone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=28, nullable=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $website;

    /**
     * @var string|null
     *
     * @ORM\Column(name="facebook", type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @var string|null
     *
     * @ORM\Column(name="twitter", type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @var string|null
     *
     * @ORM\Column(name="token_char", type="string", length=255, nullable=true)
     */
    private $tokenChar;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="token_expiry", type="datetime", nullable=true)
     */
    private $tokenExpiry;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logo", type="string", length=255, nullable=true)
     */
    private $logo;

    /**
     * @var bool
     *
     * @ORM\Column(name="subscriber", type="boolean", nullable=false, options={"default"="1"})
     */
    private $subscriber = '1';

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
     * @var \AgoraApi\Application\Entities\Entities
     *
     * @ORM\ManyToOne(targetEntity="AgoraApi\Application\Entities\Entities")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="entity_id", referencedColumnName="id")
     * })
     */
    private $entity;

    /**
     * @var \AgoraApi\Application\Entities\Roles
     *
     * @ORM\ManyToOne(targetEntity="AgoraApi\Application\Entities\Roles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role_id", referencedColumnName="id")
     * })
     */
    private $role;


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
     * Set username.
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
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set usersurname.
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
     * Get usersurname.
     *
     * @return string
     */
    public function getUsersurname()
    {
        return $this->usersurname;
    }

    /**
     * Set password.
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
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set retries.
     *
     * @param int|null $retries
     *
     * @return Contact
     */
    public function setRetries($retries = null)
    {
        $this->retries = $retries;

        return $this;
    }

    /**
     * Get retries.
     *
     * @return int|null
     */
    public function getRetries()
    {
        return $this->retries;
    }

    /**
     * Set enabled.
     *
     * @param bool|null $enabled
     *
     * @return Contact
     */
    public function setEnabled($enabled = null)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled.
     *
     * @return bool|null
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set locked.
     *
     * @param bool $locked
     *
     * @return Contact
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked.
     *
     * @return bool
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set address.
     *
     * @param string|null $address
     *
     * @return Contact
     */
    public function setAddress($address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city.
     *
     * @param string|null $city
     *
     * @return Contact
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state.
     *
     * @param string|null $state
     *
     * @return Contact
     */
    public function setState($state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state.
     *
     * @return string|null
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set postCode.
     *
     * @param string|null $postCode
     *
     * @return Contact
     */
    public function setPostCode($postCode = null)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * Get postCode.
     *
     * @return string|null
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * Set phone.
     *
     * @param string|null $phone
     *
     * @return Contact
     */
    public function setPhone($phone = null)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string|null
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email.
     *
     * @param string|null $email
     *
     * @return Contact
     */
    public function setEmail($email = null)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website.
     *
     * @param string|null $website
     *
     * @return Contact
     */
    public function setWebsite($website = null)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website.
     *
     * @return string|null
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set facebook.
     *
     * @param string|null $facebook
     *
     * @return Contact
     */
    public function setFacebook($facebook = null)
    {
        $this->facebook = $facebook;

        return $this;
    }

    /**
     * Get facebook.
     *
     * @return string|null
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * Set twitter.
     *
     * @param string|null $twitter
     *
     * @return Contact
     */
    public function setTwitter($twitter = null)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter.
     *
     * @return string|null
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set tokenChar.
     *
     * @param string|null $tokenChar
     *
     * @return Contact
     */
    public function setTokenChar($tokenChar = null)
    {
        $this->tokenChar = $tokenChar;

        return $this;
    }

    /**
     * Get tokenChar.
     *
     * @return string|null
     */
    public function getTokenChar()
    {
        return $this->tokenChar;
    }

    /**
     * Set tokenExpiry.
     *
     * @param \DateTime|null $tokenExpiry
     *
     * @return Contact
     */
    public function setTokenExpiry($tokenExpiry = null)
    {
        $this->tokenExpiry = $tokenExpiry;

        return $this;
    }

    /**
     * Get tokenExpiry.
     *
     * @return \DateTime|null
     */
    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
    }

    /**
     * Set lastLogin.
     *
     * @param \DateTime|null $lastLogin
     *
     * @return Contact
     */
    public function setLastLogin($lastLogin = null)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin.
     *
     * @return \DateTime|null
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set logo.
     *
     * @param string|null $logo
     *
     * @return Contact
     */
    public function setLogo($logo = null)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo.
     *
     * @return string|null
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set subscriber.
     *
     * @param bool $subscriber
     *
     * @return Contact
     */
    public function setSubscriber($subscriber)
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    /**
     * Get subscriber.
     *
     * @return bool
     */
    public function getSubscriber()
    {
        return $this->subscriber;
    }

    /**
     * Set updatedAt.
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
     * @return Contact
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
     * Set entity.
     *
     * @param \AgoraApi\Application\Entities\Entities|null $entity
     *
     * @return Contact
     */
    public function setEntity(\AgoraApi\Application\Entities\Entities $entity = null)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity.
     *
     * @return \AgoraApi\Application\Entities\Entities|null
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set role.
     *
     * @param \AgoraApi\Application\Entities\Roles|null $role
     *
     * @return Contact
     */
    public function setRole(\AgoraApi\Application\Entities\Roles $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return \AgoraApi\Application\Entities\Roles|null
     */
    public function getRole()
    {
        return $this->role;
    }
}
