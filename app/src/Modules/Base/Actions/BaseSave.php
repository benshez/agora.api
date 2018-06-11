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

namespace Agora\Modules\Base\Actions;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class BaseSave extends BaseAction
{
    const CURRENT_TIMESTAMP = 'CURRENT_TIMESTAMP';

    /**
     * Base Save Action
     *
     * @param $entity Entity Class.
     *
     * @return Entity Object
     */
    public function save($entity)
    {
        $this->_setTimestamps($entity);

        try {
            $manager = $this->getEntityManager();
            $manager->persist($entity);
            $manager->flush($entity);
        } catch (UniqueConstraintViolationException $e) {
            return false;
        }

        return $entity;
    }

    /**
     * Base Disable Action
     *
     * @param $entity Entity Class.
     */
    public function disable($entity)
    {
        $entity->setEnabled(false);
        $this->save($entity);
    }

    /**
     * Base Enable Action
     *
     * @param $entity Entity Class.
     */
    public function enable($entity)
    {
        $entity->setEnabled(true);
        $this->save($entity);
    }

    /**
     * Base Updated At And Created Date Action
     *
     * @param $entity Entity Class.
     */
    private function _setTimestamps($entity)
    {
        $date = new \Agora\Modules\Config\Config($this->getSettings());
        $date = $date->getDateTimeForZone();

        $entity->setUpdatedAt($date);

        if (self::CURRENT_TIMESTAMP === $entity->getCreatedAt() ||
            null === $entity->getCreatedAt()
        ) {
            $entity->setCreatedAt($date);
        }
    }
}
