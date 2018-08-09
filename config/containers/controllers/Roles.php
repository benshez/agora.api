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

use AgoraApi\Application\Controllers\RolesController;
use AgoraApi\Application\Repositories\RolesRepository;
use Psr\Container\ContainerInterface;

return [
    AgoraApiRolesController::class => function (ContainerInterface $container) {
        return new RolesController(
            $container->get('errorHandler'),
            $container->get('AgoraApiEntityManager'),
            $container->get('AgoraApiRolesRepository'),
            $container->get('AgoraApiValidator'),
            $container->get('AgoraApiParameters'),
            $container->get('AgoraApiMailService')
        );
    },

    AgoraApiRolesRepository::class => function (ContainerInterface $container) {
        return new RolesRepository($container->get('AgoraApiEntityManager'));
    },
];
