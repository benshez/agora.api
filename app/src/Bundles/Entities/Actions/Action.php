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

namespace Agora\Bundles\Entities\Actions;

use Agora\Modules\Base\Actions\BaseAction;

class Action extends BaseAction
{
    /**
     * Save Entities
     *
     * @param array $args Entities.
     *
     * @return Entities
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Entities\Actions\Save(
            $this->getContainer()
        );

        $entity = $save->onUpdate($args);

        return $entity;
    }

    /**
     * Add Entities
     *
     * @param array $args Entities.
     *
     * @return Entities
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Entities\Actions\Add(
            $this->getContainer()
        );

        $entity = $add->onAdd($args);

        return $entity;
    }

    /**
     * Delete Entities
     *
     * @param array $args User ID.
     *
     * @return Entities
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Entities\Actions\Delete(
            $this->getContainer()
        );

        $entity = $delete->onDelete($args);

        return $entity;
    }
}
