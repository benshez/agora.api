<?php
/**
 * BaseGet File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseGet
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Modules\Base\Actions;

use Interop\Container\ContainerInterface;
use Agora\Modules\Base\Actions\BaseAction;
use Agora\Modules\Base\Actions\BaseSave;

class BaseDelete extends BaseAction
{
    /**
     * Base Delete Action
     *
     * @param Object $entity Entity Class.
     *
     * @return void
     */
    public function delete($entity)
    {
        $manager = $this->getEntityManager();
        $manager->remove($entity);
        $manager->flush($entity);
    }
}
