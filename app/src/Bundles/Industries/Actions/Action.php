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

namespace Agora\Bundles\Industries\Actions;

use Agora\Modules\Config\Config;
use Agora\Modules\Base\Actions\BaseAction;
use Agora\Bundles\Industries\Validation\Validation;
use Agora\Bundles\Industries\Actions\Get;

class Action extends BaseAction
{
    /**
     * Find Industries
     *
     * @param array $args Industry.
     *
     * @return Industry
     */
    public function autoComplete(array $args)
    {
        $industry = new Get(
            $this->getContainer()
        );
        
        $industry = $industry->autoComplete($args);

        return $industry;
    }
        
    /**
     * Save Industry
     *
     * @param array $args Industry.
     *
     * @return Industry
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Industries\Actions\Save(
            $this->getContainer()
        );
        
        $industry = $save->onUpdate($args);

        return $industry;
    }
    
    /**
     * Add Industry
     *
     * @param array $args Industry.
     *
     * @return Industry
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Industries\Actions\Add(
            $this->getContainer()
        );
        
        $industry = $add->onAdd($args);

        return $industry;
    }
    
    /**
     * Delete Industry
     *
     * @param array $args Industry ID.
     *
     * @return Industry
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Industries\Actions\Delete(
            $this->getContainer()
        );
        
        $industry = $delete->onDelete($args);

        return $industry;
    }
}
