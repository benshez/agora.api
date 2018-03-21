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

namespace Agora\Bundles\Options\Actions;

use Agora\Modules\Config\Config;
use Agora\Modules\Base\Actions\BaseAction;
use Agora\Modules\Base\Interfaces\IBaseAction;
use Agora\Bundles\Contact\Validation\Validation;

class Action extends BaseAction
{
    const REFERENCE = 'options';
  

    /**
     * Get Options
     *
     * @param array $args Options.
     *
     * @return Options
     */
    public function onGet(array $args)
    {
        $get = new \Agora\Bundles\Options\Actions\Get(
            $this->getContainer()
        );
        
        $options = $get->onGet($args);

        return $options;
    }
        
    /**
     * Save Options
     *
     * @param array $args Options.
     *
     * @return Options
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Options\Actions\Save(
            $this->getContainer()
        );
        
        $options = $save->onUpdate($args);

        return $options;
    }
    
    /**
     * Add Options
     *
     * @param array $args Options.
     *
     * @return Options
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Options\Actions\Add(
            $this->getContainer()
        );
        
        $options = $add->onAdd($args);

        return $options;
    }
    
    /**
     * Delete Options
     *
     * @param array $args Options ID.
     *
     * @return Options
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Contact\Options\Delete(
            $this->getContainer()
        );
        
        $options = $delete->onDelete($args);

        return $options;
    }
}
