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

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Agora\Modules\Config\Config;
use Slim\Collection;
use Slim\Container;

trait TimestampableTrait
{
    /**
     * @var DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var DateTime
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

        if ('CURRENT_TIMESTAMP' === $this->getCreatedAt() ||
            null === $this->getCreatedAt()
        ) {
            $this->setCreatedAt($date);
        }

        $this->setUpdatedAt($date);
    }

    /** @ORM\PostPersist */
    public function onPostPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof \Agora\Bundles\Contact\Entity\Contact) {
            $mailer = $this->getContainer()->get('mailer');

            $data = [
                'email' => $entity->getEmail(),
                'text' => 'Please verify email to submit enquiry!',
                'template'  => 'User'
            ];
    
            $mailer->send('User/Registration.twig', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email']);
                $message->from('benshez1@gmail.com');
                $message->fromName('Ben van Heerden');
                $message->subject('Please verify email to submit enquiry!');
            });
        }
    }

    /**
     * Get getTimeZoneDateTime
     *
     * @return datetime
     */
    private function getTimeZoneDateTime()
    {
        $config = $this->getConfig();
        return $config->getDateTimeForZone();
    }

    /**
     * Get Config
     *
     * @return Agora\Modules\Config\Config
     */
    private function getConfig()
    {
        return $this->setConfig();
    }

    /**
     * Set Config
     *
     * @return Agora\Modules\Config\Config
     */
    private function setConfig()
    {
        $settings = $this->getContainer()->get('settings');
        return new Config($settings);
    }

    /**
     * Get Container
     *
     * @return Slim\Container
     */
    private function getContainer()
    {
          return $this->setContainer();
    }

    /**
     * Set Container
     *
     * @return Slim\Container
     */
    private function setContainer()
    {
        global $app;
        return $app->getContainer();
    }
}
