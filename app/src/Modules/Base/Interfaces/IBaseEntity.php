<?php
/**
 * BaseEntity File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseEntity
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Modules\Base\Interfaces;

use Doctrine\ORM\Mapping;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Agora\Modules\Base\Interfaces\IBaseModel;
use Agora\Modules\Base\Interfaces\IBaseEntity;

interface IBaseEntity
{
    /**
     * Base Entity
     *
     * @param EntityManager         $manager Manager.
     *
     * @param Mapping\ClassMetadata $class   Class.
     *
     * @return void
     */
    public function __construct($manager, Mapping\ClassMetadata $class);
    
    /**
     * Find One By
     *
     * @param array $criteria Criteria.
     *
     * @param array $orderBy  Class.
     *
     * @return One
     */
    public function findOneBy(array $criteria, array $orderBy = null);
    
    /**
     * Find One By
     *
     * @param array   $criteria Criteria.
     *
     * @param array   $orderBy  Class.
     *
     * @param integer $limit    Class.
     *
     * @param integer $offset   Class.
     *
     * @return One
     */
    public function findBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    );
}
