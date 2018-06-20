<?php
/**
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

namespace Agora\Bundles\Locations\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locations
 *
 * @ORM\Table(name="locations", indexes={@ORM\Index(name="idx_ip_from", columns={"ip_from"}), @ORM\Index(name="idx_ip_to", columns={"ip_to"}), @ORM\Index(name="idx_ip_from_to", columns={"ip_from", "ip_to"}), @ORM\Index(name="fk_locations_contact_id_contact_id_idx", columns={"contact_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Agora\Bundles\Locations\Entity\Repository")
 */
class Locations
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
     * @var null|string
     *
     * @ORM\Column(name="ip_from", type="string", length=18, nullable=true, options={"fixed"=true})
     */
    private $ipFrom;

    /**
     * @var null|string
     *
     * @ORM\Column(name="ip_to", type="string", length=18, nullable=true, options={"fixed"=true})
     */
    private $ipTo;

    /**
     * @var null|string
     *
     * @ORM\Column(name="country_code", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $countryCode;

    /**
     * @var null|string
     *
     * @ORM\Column(name="country_name", type="string", length=64, nullable=true)
     */
    private $countryName;

    /**
     * @var null|string
     *
     * @ORM\Column(name="region_name", type="string", length=128, nullable=true)
     */
    private $regionName;

    /**
     * @var null|string
     *
     * @ORM\Column(name="city_name", type="string", length=128, nullable=true)
     */
    private $cityName;

    /**
     * @var null|float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var null|float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var null|string
     *
     * @ORM\Column(name="zip_code", type="string", length=30, nullable=true)
     */
    private $zipCode;

    /**
     * @var null|string
     *
     * @ORM\Column(name="time_zone", type="string", length=8, nullable=true)
     */
    private $timeZone;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \Contact
     *
     * @ORM\ManyToOne(targetEntity="\Agora\Bundles\Contact\Entity\Contact")
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
     * Set ipFrom.
     *
     * @param null|string $ipFrom
     *
     * @return Locations
     */
    public function setIpFrom($ipFrom = null)
    {
        $this->ipFrom = $ipFrom;

        return $this;
    }

    /**
     * Get ipFrom.
     *
     * @return null|string
     */
    public function getIpFrom()
    {
        return $this->ipFrom;
    }

    /**
     * Set ipTo.
     *
     * @param null|string $ipTo
     *
     * @return Locations
     */
    public function setIpTo($ipTo = null)
    {
        $this->ipTo = $ipTo;

        return $this;
    }

    /**
     * Get ipTo.
     *
     * @return null|string
     */
    public function getIpTo()
    {
        return $this->ipTo;
    }

    /**
     * Set countryCode.
     *
     * @param null|string $countryCode
     *
     * @return Locations
     */
    public function setCountryCode($countryCode = null)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode.
     *
     * @return null|string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set countryName.
     *
     * @param null|string $countryName
     *
     * @return Locations
     */
    public function setCountryName($countryName = null)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName.
     *
     * @return null|string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set regionName.
     *
     * @param null|string $regionName
     *
     * @return Locations
     */
    public function setRegionName($regionName = null)
    {
        $this->regionName = $regionName;

        return $this;
    }

    /**
     * Get regionName.
     *
     * @return null|string
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set cityName.
     *
     * @param null|string $cityName
     *
     * @return Locations
     */
    public function setCityName($cityName = null)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName.
     *
     * @return null|string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set latitude.
     *
     * @param null|float $latitude
     *
     * @return Locations
     */
    public function setLatitude($latitude = null)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude.
     *
     * @return null|float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param null|float $longitude
     *
     * @return Locations
     */
    public function setLongitude($longitude = null)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude.
     *
     * @return null|float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set zipCode.
     *
     * @param null|string $zipCode
     *
     * @return Locations
     */
    public function setZipCode($zipCode = null)
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    /**
     * Get zipCode.
     *
     * @return null|string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set timeZone.
     *
     * @param null|string $timeZone
     *
     * @return Locations
     */
    public function setTimeZone($timeZone = null)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone.
     *
     * @return null|string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Set createdAt.
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
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
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
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set contact.
     *
     * @param null|\Contact $contact
     *
     * @return Locations
     */
    public function setContact(\Contact $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact.
     *
     * @return null|\Contact
     */
    public function getContact()
    {
        return $this->contact;
    }
}
