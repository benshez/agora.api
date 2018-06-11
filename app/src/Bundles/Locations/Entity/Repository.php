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

namespace Agora\Bundles\Locations\Entity;

use Agora\Bundles\Contact\Entity\Contact;
use Agora\Bundles\Entities\Entity\Entities;
use Agora\Bundles\Industries\Entity\Industries;
use Agora\Modules\Base\Entity\BaseEntity;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;

class Repository extends BaseEntity
{
    /**
     * Find One By
     *
     * @param array   $criteria Criteria.
     *
     * @param array   $orderBy  Class.
     *
     * @param int $limit    Class.
     *
     * @param int $offset   Class.
     *
     * @return One
     */
    public function findBy(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ) {
        $query = $this->getQuery($criteria['industry'], $orderBy, $limit, $offset);

        try {
            $locations = $query->getResult(Query::HYDRATE_ARRAY);

            return $locations;
        } catch (NoResultException $e) {
            return false;
        }
    }

    /**
     * Generate Query
     *
     * @param string $criteria Criteria.
     *
     * @param array  $orderBy  Class.
     * @param null|mixed $limit
     * @param null|mixed $offset
     *
     * @return Query
     */
    private function getQuery(
        string $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null
    ) {
        $qb = $this->_em->createQueryBuilder();

        $qb->select($this->getSelectStatement())
        ->from(Entities::class, 'entities')
        ->innerJoin(
            Contact::class,
            'contact',
            Join::WITH,
            '(contact.entity = entities.id)'
        )
        ->innerJoin(
            Locations::class,
            'locations',
            Join::WITH,
            '(locations.user = contact.id)'
        )
        ->innerJoin(
            Industries::class,
            'industries',
            Join::WITH,
            '(entities.industry = industries.id)'
        )
        ->where('industries.id = :identifier')
        ->andWhere('entities.enabled = 1')
        ->andWhere('contact.enabled = 1')
        ->andWhere('entities.expiresAt >= :expires')
        ->setParameter('identifier', $criteria)
        ->setParameter('expires', $this->getFormattedDate())
        ->orderBy($orderBy[0], 'desc')
        ->setFirstResult($offset)
        ->setMaxResults($limit);

        $query = $qb->getQuery();

        return $query;
    }

    /**
     * Generate Formatted Date
     *
     * @return string
     */
    private function getFormattedDate()
    {
        $date = new \DateTime();
        $formatted = $date->format('Y-m-d') . '\'';

        return $formatted;
    }

    /**
     * Generate Select Statement
     *
     * @return string
     */
    private function getSelectStatement()
    {
        $statement = 'locations.id, entities.name, ';
        $statement .= 'locations.latitude, locations.longitude, ';
        $statement .= 'contact.username, contact.phone, ';
        $statement .= 'contact.logo, contact.email, contact.website, ';
        $statement .= 'contact.facebook, contact.twitter';

        return $statement;
    }
}
