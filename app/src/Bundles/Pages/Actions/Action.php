<?php
/**
 * BaseGet File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseSave
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Bundles\Pages\Actions;

use Agora\Modules\Config\Config;
use Agora\Modules\Base\Actions\BaseAction;
use Agora\Bundles\Pages\Validation\Validation;

class Action extends BaseAction
{

    /**
     * Get Pages
     *
     * @param array $args Pages.
     *
     * @return Pages
     */
    public function onGet(array $args)
    {
        $get = new \Agora\Bundles\Pages\Actions\Get(
            $this->getContainer()
        );
        
        $pages = $get->onGet($args);

        return $pages;
    }
         
    /**
     * Save Pages
     *
     * @param array $args Pages.
     *
     * @return Pages
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Pages\Actions\Save(
            $this->getContainer()
        );
        
        $page = $save->onUpdate($args);

        return $page;
    }
    
    /**
     * Add Locations
     *
     * @param array $args Pages.
     *
     * @return Pages
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Pages\Actions\Add(
            $this->getContainer()
        );
        
        $page = $add->onAdd($args);

        return $page;
    }
    
    /**
     * Delete Pages
     *
     * @param array $args Pages ID.
     *
     * @return Pages
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Pages\Actions\Delete(
            $this->getContainer()
        );
        
        $page = $delete->onDelete($args);

        return $page;
    }
}
