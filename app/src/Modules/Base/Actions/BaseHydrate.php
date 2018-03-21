<?php
/**
 * BaseHydrate File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseHydrate
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Modules\Base\Actions;

use \ReflectionObject;
use Doctrine\Common\Util\Inflector;
use Interop\Container\ContainerInterface;
use Agora\Modules\Base\Actions\BaseAction;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityRepository;

class BaseHydrate extends BaseAction
{
    const PROP_NAME = 'name';
    const ANNOTATION_NAME = 'Doctrine\ORM\Mapping\Column';
    const SETTER_START = 'set%s';
    
    /**
     * Base Hydrate Entity Action
     *
     * @param       $entity Sender Is Entity Class.
     *
     * @param array $args Args Is Arguments To Pass.
     *
     * @return Entity Object
     */
    public function hydrate($entity, array $args)
    {
        $refObj = new \ReflectionObject($entity);
        $reader = new AnnotationReader();
        $columns = array_column($refObj->getProperties(), self::PROP_NAME);
        
        foreach ($args as $key => $property) {
            $setter = sprintf(self::SETTER_START, ucfirst(Inflector::camelize($key)));
            $column = array_search($key, $columns);
            $annotation = $reader->getPropertyAnnotation(
                $refObj->getProperties()[$column],
                self::ANNOTATION_NAME
            );
            
            if ($annotation && method_exists($entity, $setter)) {
                if (isset($args[$key])) {
                    //$entity->$setter($args[Inflector::tableize($annotation->name)]);
                    $entity->$setter($args[$key]);
                }
            }
        }

        return $entity;
    }
    
    /**
     * Base Hydrate Entity Action
     *
     * @param       $entity Sender Is Entity Class.
     *
     * @param array $args Args Is Arguments To Pass.
     *
     * @return Entity To Array
     */
    public function extract(EntityRepository $entity, array $args)
    {
        $hydrator = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject(
            $this->getEntityManager()
        );
        $entityArray = $hydrator->extract($entity);
        
        return $entityArray;
    }
}
