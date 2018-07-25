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

use Firebase\JWT\JWT;
use Tuupola\Base62;
use AgoraApi\Application\Services\AuthenticationService;

//$app->post('/token', function ($request, $response, $arguments) {
$app->post('/token', function ($request, $response, $arguments = null) {
    $requested_scopes = $request->getParsedBody() ?: [];

    $valid_scopes = [
        'todo.create',
        'todo.read',
        'todo.update',
        'todo.delete',
        'todo.list',
        'todo.all',
    ];

    $scopes = array_filter($requested_scopes, function ($needle) use ($valid_scopes) {
        return in_array($needle, $valid_scopes);
    });

    $now = new DateTime();
    $future = new DateTime('now +2 hours');
    $server = $request->getServerParams();

    $jti = (new Base62())->encode(random_bytes(16));

    $payload = [
        'iat' => $now->getTimeStamp(),
        'exp' => $future->getTimeStamp(),
        'jti' => $jti,
        'sub' => $server['PHP_AUTH_USER'],
        'scope' => $scopes,
    ];

    $secret = getenv('JWT_SECRET');
    $token = JWT::encode($payload, $secret, 'HS256');

    $data['token'] = $token;
    $data['expires'] = $future->getTimeStamp();

    return $response->withStatus(201)
        ->withHeader('Content-Type', 'application/json')
        ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
});

/* This is just for debugging, not usefull in real life. */
$app->get('/dump', function ($request, $response, $arguments) {
    print_r($this->token);
});

$app->post('/dump', function ($request, $response, $arguments) {
    print_r($this->token);
});

/* This is just for debugging, not usefull in real life. */
$app->get('/info', function ($request, $response, $arguments) {
    phpinfo();
});