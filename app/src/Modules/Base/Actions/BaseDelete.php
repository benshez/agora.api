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

class BaseDelete extends BaseAction
{
    /**
     * Base Delete Action
     *
     * @param object $entity entity Class
     */
    public function delete($entity)
    {
        $manager = $this->getEntityManager();
        $manager->remove($entity);
        $manager->flush($entity);
    }
}
