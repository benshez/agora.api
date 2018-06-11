<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Locations
 *
 * @ORM\Table(name="locations", indexes={@ORM\Index(name="idx_ip_from", columns={"ip_from"}), @ORM\Index(name="idx_ip_to", columns={"ip_to"}), @ORM\Index(name="idx_ip_from_to", columns={"ip_from", "ip_to"}), @ORM\Index(name="fk_locations_contact_id_contact_id_idx", columns={"contact_id"})})
 * @ORM\Entity
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
     * @var string|null
     *
     * @ORM\Column(name="ip_from", type="string", length=18, nullable=true, options={"fixed"=true})
     */
    private $ipFrom;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ip_to", type="string", length=18, nullable=true, options={"fixed"=true})
     */
    private $ipTo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_code", type="string", length=2, nullable=true, options={"fixed"=true})
     */
    private $countryCode;

    /**
     * @var string|null
     *
     * @ORM\Column(name="country_name", type="string", length=64, nullable=true)
     */
    private $countryName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="region_name", type="string", length=128, nullable=true)
     */
    private $regionName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="city_name", type="string", length=128, nullable=true)
     */
    private $cityName;

    /**
     * @var float|null
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $latitude;

    /**
     * @var float|null
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=0, nullable=true)
     */
    private $longitude;

    /**
     * @var string|null
     *
     * @ORM\Column(name="zip_code", type="string", length=30, nullable=true)
     */
    private $zipCode;

    /**
     * @var string|null
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
     * @ORM\ManyToOne(targetEntity="Contact")
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
     * @param string|null $ipFrom
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
     * @return string|null
     */
    public function getIpFrom()
    {
        return $this->ipFrom;
    }

    /**
     * Set ipTo.
     *
     * @param string|null $ipTo
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
     * @return string|null
     */
    public function getIpTo()
    {
        return $this->ipTo;
    }

    /**
     * Set countryCode.
     *
     * @param string|null $countryCode
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
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set countryName.
     *
     * @param string|null $countryName
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
     * @return string|null
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set regionName.
     *
     * @param string|null $regionName
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
     * @return string|null
     */
    public function getRegionName()
    {
        return $this->regionName;
    }

    /**
     * Set cityName.
     *
     * @param string|null $cityName
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
     * @return string|null
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set latitude.
     *
     * @param float|null $latitude
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
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude.
     *
     * @param float|null $longitude
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
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set zipCode.
     *
     * @param string|null $zipCode
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
     * @return string|null
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * Set timeZone.
     *
     * @param string|null $timeZone
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
     * @return string|null
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
     * @param \Contact|null $contact
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
     * @return \Contact|null
     */
    public function getContact()
    {
        return $this->contact;
    }
}
