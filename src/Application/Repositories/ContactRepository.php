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
use AgoraApi\Application\Entities\Contact;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;

class ContactRepository implements IRepository
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
     * ContactRepository constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->_entityManager = $entityManager;
    }

    public function autenticate(int $id, $password)
    {
        $this->_queryBuilder = $this->_entityManager->createQueryBuilder();

        $this->_queryBuilder->select('Contact')
            ->from(Contact::class, 'Contact')
            ->where('Contact.username = :id')
            ->orWhere('Contact.email = :id')
            ->andWhere('Contact.password = :password')
            ->andWhere('Contact.locked = 0')
            ->setParameter('id', $id)
            ->setParameter('password', $password);

        return $query = $this->_queryBuilder->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }

    public function findOneByEmail($email)
    {
        $this->_queryBuilder = $this->_entityManager->createQueryBuilder();

        $this->_queryBuilder->select('Contact')
            ->from(Contact::class, 'Contact')
            ->orWhere('Contact.email = :id')
            ->andWhere('Contact.locked = 0')
            ->setParameter('id', $email);

        return $query = $this->_queryBuilder->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }

    /**
     * @param id $id
     *
     * @throws ORMException
     * @throws ORMInvalidArgumentException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     *
     * @return null|object|Contact
     */
    public function findById(int $id)
    {
        return $this->_entityManager->find(Contact::class, $id);
    }

    public function findPaginated(int $offset, int $limit = null)
    {
        $this->_queryBuilder = $this->_entityManager->createQueryBuilder();

        $this->_queryBuilder->select('Contact')
            ->from(Contact::class, 'Contact')
            ->setMaxResults((null === $limit) ? 10 : $limit)
            ->setFirstResult($offset);

        return $query = $this->_queryBuilder->getQuery()->getResult(Query::HYDRATE_OBJECT);
    }
}
