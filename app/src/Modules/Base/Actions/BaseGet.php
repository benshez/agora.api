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

namespace Agora\Modules\Base\Actions;

use Interop\Container\ContainerInterface;
use Doctrine\Common\Collections\Criteria;
use Agora\Modules\Base\Actions\BaseAction;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter;

class BaseGet extends BaseAction
{

    /**
     * Base Get Action
     *
     * @param string $entity Entity Class.
     *
     * @param array  $args   Args Is Arguments To Pass.
     *
     * @return Entity Object
     */
    public function get(string $entity, array $args = null)
    {
        if ($args === null) {
            $objects = $this->getEntityManager()->getRepository($entity)->findAll();

            $objects = array_map(
                function ($object) {
                    return $object;
                }, $objects
            );

            return $objects;
        } else {
            $object = $this->getEntityManager()->getRepository($entity)->findOneBy($args);
            
            if ($object) {
                return $object;
            }
        }

        return false;
    }
    
    /**
     * Base Get Paged Action
     *
     * @param string $entity Entity Class.
     *
     * @param array  $args   Args Is Arguments To Pass.
     *
     * @return Entity Paged Object
     */
    public function getPaged(string $entity, array $args = null)
    {
        $offset = (isset($args['offset']) && $args['offset'] < 0) ?
        $args['offset'] : 1;
        $limit = 10;
        $offset = ($limit * ($offset - 1));
        $key = isset($args['value']) ? $args['value'] : null;
        
        $criteria = null;

        if ($key !== null) {
            $criteria = Criteria::create()
            ->where(Criteria::expr()->eq($args['key'], $key));
        }
        
        $adapter = new SelectableAdapter(
            $this->getEntityManager()->getRepository(
                $entity
            ),
            $criteria
        );

        $paginator = new ORMPaginator($adapter->getItems($offset, $limit));
        
        $paginator = $paginator->getQuery();

        return ($paginator);
    }
}
