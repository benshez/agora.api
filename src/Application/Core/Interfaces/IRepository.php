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

namespace AgoraApi\Application\Core\Interfaces;

use Doctrine\ORM\EntityManager;

interface IRepository
{
    public function __construct(EntityManager $entityManager);

    public function findById(int $id);

    public function findPaginated(int $offset, int $id = null);
}
