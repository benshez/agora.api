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


return [
    AgoraApiHTTPClient::class => function (ContainerInterface $container) {
        return new \GuzzleHttp\Client();
    },

    AgoraApiAsyncHTTPClient::class => function (ContainerInterface $container) {
    },
];
