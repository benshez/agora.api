<?php

namespace Agora\Bundles\Locations\Entity;

use Doctrine\ORM\Mapping as ORM;
use Agora\Bundles\Users\Entity\Users;

/**
 * Locations
 *
 * @ORM\Table(name="locations", indexes={@ORM\Index(name="idx_ip_from", columns={"ip_from"}), @ORM\Index(name="idx_ip_to", columns={"ip_to"}), @ORM\Index(name="idx_ip_from_to", columns={"ip_from", "ip_to"}), @ORM\Index(name="fk_locations_user_id_contact_id_idx", columns={"user_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Agora\Bundles\Locations\Entity\Repository")
 */

class Locations
{
    /**
      * @var integer
      *
      * @ORM\Column(name="id", type="integer")
      * @ORM\Id
      * @ORM\GeneratedValue(strategy="IDENTITY")
      */
    private $id;
 
    /**
      * @var integer
      *
      * @ORM\Column(name="ip_from", type="integer", nullable=true)
      */
    private $ipFrom;
 
    /**
      * @var integer
      *
      * @ORM\Column(name="ip_to", type="integer", nullable=true)
      */
    private $ipTo;
 
    /**
      * @var string
      *
      * @ORM\Column(name="country_code", type="string", length=2, nullable=true)
      */
    private $countryCode;
 
    /**
      * @var string
      *
      * @ORM\Column(name="country_name", type="string", length=64, nullable=true)
      */
    private $countryName;
 
    /**
      * @var string
      *
      * @ORM\Column(name="region_name", type="string", length=128, nullable=true)
      */
    private $regionName;
 
    /**
      * @var string
      *
      * @ORM\Column(name="city_name", type="string", length=128, nullable=true)
      */
    private $cityName;
 
    /**
      * @var float
      *
      * @ORM\Column(name="latitude", type="string", length=18, nullable=true)
      */
    private $latitude;
 
    /**
      * @var float
      *
      * @ORM\Column(name="longitude", type="string", length=18, nullable=true)
      */
    private $longitude;
 
    /**
      * @var string
      *
      * @ORM\Column(name="zip_code", type="string", length=30, nullable=true)
      */
    private $zipCode;
 
    /**
      * @var string
      *
      * @ORM\Column(name="time_zone", type="string", length=8, nullable=true)
      */
    private $timeZone;
 
    /**
      * @var \DateTime
      *
      * @ORM\Column(name="created_at", type="datetime", nullable=false)
      */
    private $createdAt = 'CURRENT_TIMESTAMP';
 
    /**
      * @var \DateTime
      *
      * @ORM\Column(name="updated_at", type="datetime", nullable=false)
      */
    private $updatedAt = 'CURRENT_TIMESTAMP';
 
    /**
      * @var \Contact
      *
      * @ORM\ManyToOne(targetEntity="\Agora\Bundles\Contact\Entity\Contact")
      * @ORM\JoinColumns({
      *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
      * })
      */
    private $user;
 
 
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
      * Set ipFrom
      *
      * @param integer $ipFrom
      *
      * @return Locations
      */
    public function setIpFrom($ipFrom)
    {
        $this->ipFrom = $ipFrom;
 
        return $this;
    }
 
    /**
      * Get ipFrom
      *
      * @return integer
      */
    public function getIpFrom()
    {
        return $this->ipFrom;
    }
 
    /**
      * Set ipTo
      *
      * @param integer $ipTo
      *
      * @return Locations
      */
    public function setIpTo($ipTo)
    {
        $this->ipTo = $ipTo;
 
        return $this;
    }
 
    /**
      * Get ipTo
      *
      * @return integer
      */
    public function getIpTo()
    {
        return $this->ipTo;
    }
 
    /**
      * Set countryCode
      *
      * @param string $countryCode
      *
      * @return Locations
      */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
 
        return $this;
    }
 
    /**
      * Get countryCode
      *
      * @return string
      */
    public function getCountryCode()
    {
        return $this->countryCode;
    }
 
    /**
      * Set countryName
      *
      * @param string $countryName
      *
      * @return Locations
      */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;
 
        return $this;
    }
 
    /**
      * Get countryName
      *
      * @return string
      */
    public function getCountryName()
    {
        return $this->countryName;
    }
 
    /**
      * Set regionName
      *
      * @param string $regionName
      *
      * @return Locations
      */
    public function setRegionName($regionName)
    {
        $this->regionName = $regionName;
 
        return $this;
    }
 
    /**
      * Get regionName
      *
      * @return string
      */
    public function getRegionName()
    {
        return $this->regionName;
    }
 
    /**
      * Set cityName
      *
      * @param string $cityName
      *
      * @return Locations
      */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;
 
        return $this;
    }
 
    /**
      * Get cityName
      *
      * @return string
      */
    public function getCityName()
    {
        return $this->cityName;
    }
 
    /**
      * Set latitude
      *
      * @param float $latitude
      *
      * @return Locations
      */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
 
        return $this;
    }
 
    /**
      * Get latitude
      *
      * @return float
      */
    public function getLatitude()
    {
        return $this->latitude;
    }
 
    /**
      * Set longitude
      *
      * @param float $longitude
      *
      * @return Locations
      */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
 
        return $this;
    }
 
    /**
      * Get longitude
      *
      * @return float
      */
    public function getLongitude()
    {
        return $this->longitude;
    }
 
    /**
      * Set zipCode
      *
      * @param string $zipCode
      *
      * @return Locations
      */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
 
        return $this;
    }
 
    /**
      * Get zipCode
      *
      * @return string
      */
    public function getZipCode()
    {
        return $this->zipCode;
    }
 
    /**
      * Set timeZone
      *
      * @param string $timeZone
      *
      * @return Locations
      */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;
 
        return $this;
    }
 
    /**
      * Get timeZone
      *
      * @return string
      */
    public function getTimeZone()
    {
        return $this->timeZone;
    }
 
    /**
      * Set createdAt
      *
      * @param \DateTime $createdAt
      *
      * @return Locations
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
      * Set updatedAt
      *
      * @param \DateTime $updatedAt
      *
      * @return Locations
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
      * Set user
      *
      * @param \Agora\Bundles\Contact\Entity\Contact $user
      *
      * @return Locations
      */
    public function setUser(\Agora\Bundles\Contact\Entity\Contact $user = null)
    {
        $this->user = $user;
 
        return $this;
    }
 
    /**
      * Get user
      *
      * @return \Agora\Bundles\Contact\Entity\Contact
      */
    public function getUser()
    {
        return $this->user;
    }
}
