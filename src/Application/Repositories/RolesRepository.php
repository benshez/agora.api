<?php

/*
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

declare(strict_types=1);

namespace AgoraApi\Application\Repositories;

use AgoraApi\Application\Core\Interfaces\IRepository;
use AgoraApi\Application\Entities\Roles;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class RolesRepository implements IRepository
{
    /**
     * @var EntityManager
     */
    private $_entityManager;

    /**
     * @var QueryBuilder
     */
    private $_queryBuilder;

    /**
     * RolesRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * @param id $id
     *
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     *
     * @return null|object|Role
     */
    public function findById(int $id)
    {
        return $this->_entityManager->find(Roles::class, $id);
    }

    public function findPaginated(int $offset, int $limit = null)
    {
        $this->_queryBuilder = $this->_entityManager->createQueryBuilder();

        $this->_queryBuilder->select('Roles')
            ->from(Roles::class, 'Roles')
            ->setMaxResults((null === $limit) ? 10 : $limit)
            ->setFirstResult($offset);

        return $query = $this->_queryBuilder->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }
}
