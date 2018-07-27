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

use AgoraApi\Application\Controllers\AuthenticationController;
use AgoraApi\Application\Repositories\RoleRoutesRepository;
use Psr\Container\ContainerInterface;

return [
    AgoraApiAuthenticationController::class => function (ContainerInterface $container) {
        return new AuthenticationController(
            $container->get('errorHandler'),
            $container->get('AgoraApiEntityManager'),
            $container->get('AgoraApiContactRepository'),
            $container->get('AgoraApiRoleRoutesRepository'),
            $container->get('AgoraApiValidator'),
            $container->get('AgoraApiParameters')
        );
    },

    AgoraApiRoleRoutesRepository::class => function (ContainerInterface $container) {
        return new RoleRoutesRepository($container->get('AgoraApiEntityManager'));
    },
];
