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

namespace Agora\Bundles\Locations\Actions;

use Agora\Modules\Base\Actions\BaseAction;

class Action extends BaseAction
{
    /**
     * Get Locations
     *
     * @param array $args Locations.
     *
     * @return Locations
     */
    public function onGet(array $args)
    {
        $get = new \Agora\Bundles\Locations\Actions\Get(
             $this->getContainer()
         );

        $location = $get->onGet($args);

        return $location;
    }

    /**
     * Save Locations
     *
     * @param array $args Locations.
     *
     * @return Locations
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Locations\Actions\Save(
            $this->getContainer()
        );

        $location = $save->onUpdate($args);

        return $location;
    }

    /**
     * Add Locations
     *
     * @param array $args Locations.
     *
     * @return Locations
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Locations\Actions\Add(
            $this->getContainer()
        );

        $location = $add->onAdd($args);

        return $location;
    }

    /**
     * Delete Locations
     *
     * @param array $args Locations ID.
     *
     * @return Locations
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Locations\Actions\Delete(
            $this->getContainer()
        );

        $location = $delete->onDelete($args);

        return $location;
    }
}
