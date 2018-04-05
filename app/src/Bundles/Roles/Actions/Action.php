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
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Roles\Actions;

use Agora\Modules\Config\Config;
use Agora\Modules\Base\Actions\BaseAction;
use Agora\Bundles\Contact\Validation\Validation;

class Action extends BaseAction
{
    
    /**
     * Get Role
     *
     * @param array $args Role.
     *
     * @return Role
     */
    public function onGet(array $args)
    {
        $get = new \Agora\Bundles\Roles\Actions\Get(
            $this->getContainer()
        );
        
        $role = $get->onGet($args);

        return $role;
    }
        
    /**
     * Save Role
     *
     * @param array $args User Password.
     *
     * @return User
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Roles\Actions\Save(
            $this->getContainer()
        );
        
        $role = $save->onUpdate($args);

        return $role;
    }
    
    /**
     * Add Role
     *
     * @param array $args Role.
     *
     * @return Role
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Role\Actions\Add(
            $this->getContainer()
        );
        
        $role = $add->onAdd($args);

        return $role;
    }
    
    /**
     * Delete Role
     *
     * @param array $args Role ID.
     *
     * @return Role
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Role\Actions\Delete(
            $this->getContainer()
        );
        
        $role = $delete->onDelete($args);

        return $role;
    }
    
    /**
     * Role To Array
     *
     * @param \Agora\Bundles\Roles\Entity\Roles $args Role.
     *
     * @return Role
     */
    public function roleToArray(\Agora\Bundles\Roles\Entity\Roles $args)
    {
        return array(
            'id' => $args->getId(),
            'role' => $args->getRole(),
            'enabled' => $args->getEnabled()
        );
    }
}
