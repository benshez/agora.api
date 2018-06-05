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

namespace Agora\Modules\Base\Traits;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

trait TimestampableTrait
{
    /**
     * @var DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * Get createdAt
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     */
    public function setCreatedAt($createdAt)
    {   
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /** 
     * Set updatedAt 
     * 
     * @ORM\PreUpdate 
     */  
    public function onPreUpdate()  
    {  
        $this->setUpdatedAt = $this->getTimeZoneDateTime();  
    }  

    /** @ORM\PrePersist */
    public function onPrePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();
        $date = $this->getTimeZoneDateTime();

        if ($this->getCreatedAt() === 'CURRENT_TIMESTAMP' ||
            null === $this->getCreatedAt()
        ) {
            $this->setCreatedAt($date);
        }

        $this->setUpdatedAt($date);
    }

    /**
     * Get getTimeZoneDateTime
     *
     * @return datetime
     */
    private function getTimeZoneDateTime() 
    {
        $config = new \Agora\Modules\Config\Config();

        $config = $config->getConfig();

        $date = new \Agora\Modules\Config\Config(new \Slim\Collection($config['settings']));

        return $date->getDateTimeForZone();
    }
}