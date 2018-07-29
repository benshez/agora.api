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

/*
 * This file is part of the Slim API skeleton package
 *
 * Copyright (c) 2016-2017 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/slim-api-skeleton
 *
 */


$app->group('/token', function () use ($app) {
    $app->post('/generate', 'AgoraApiAuthenticationController::authenticate');

    /* This is just for debugging, not usefull in real life. */
    $app->get('/dump', function ($request, $response, $arguments = null) {
        print_r($this->token);
    });

    $app->post('/dump', function ($request, $response, $arguments = null) {
        print_r($this->token);
    });

    /* This is just for debugging, not usefull in real life. */
    $app->get('/info', function ($request, $response, $arguments = null) {
        phpinfo();
    });
});
