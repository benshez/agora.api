<?php



use Doctrine\ORM\Mapping as ORM;

/**
 * Migrations
 *
 * @ORM\Table(name="migrations")
 * @ORM\Entity
 */
class Migrations
{
    /**
     * @var string
     *
     * @ORM\Column(name="version", type="string", length=255)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $version;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="apply_time", type="datetime", nullable=false)
     */
    private $applyTime = 'CURRENT_TIMESTAMP';


    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set applyTime
     *
     * @param \DateTime $applyTime
     *
     * @return Migrations
     */
    public function setApplyTime($applyTime)
    {
        $this->applyTime = $applyTime;

        return $this;
    }

    /**
     * Get applyTime
     *
     * @return \DateTime
     */
    public function getApplyTime()
    {
        return $this->applyTime;
    }
}

