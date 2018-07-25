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

use AgoraApi\Core\Adapters\RoutesAdapter;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use Psr\Container\ContainerInterface;

return [
    AgoraApiApp::class => function (ContainerInterface $container) {
        global $app;
        return $app;
    },
    AgoraApiParameters::class => function (ContainerInterface $container) {
        return new AgoraApiConfiguration();
    },
    AgoraApiRoutes::class => function (ContainerInterface $container) {
        return new RoutesAdapter($container->get(AgoraApiApp::class));
    },
    AgoraApiValidator::class => function (ContainerInterface $container) {
        $config = $container->get(AgoraApiParameters::class);

        return new AgoraApi\Application\Core\Validation\Validator(
            $config
        );
    },
];
