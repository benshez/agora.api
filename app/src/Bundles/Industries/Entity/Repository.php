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

namespace Agora\Bundles\Industries\Entity;

use Agora\Modules\Base\Entity\BaseEntity;

class Repository extends BaseEntity
{
    /**
     * Find Industries By Descrptions
     *
     * @param array $criteria Industry.
     *
     * @param array $orderBy  Order Data By.
     *
     * @return Industry
     */
    public function findAllByDescription(
        array $criteria,
        array $orderBy = null
    ) {
    
        $description = strtolower($criteria['description']);

        $qb = $this->_em->createQueryBuilder('u');
        $qb->select('u.id, u.description')
        ->from(Industries::class, 'u')
        ->where($qb->expr()->like('LOWER(u.description)', ':identifier'))
        ->setParameter('identifier', "%$description%");

        $query = $qb->getQuery();

        $data = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        
        return $data;
    }
}
