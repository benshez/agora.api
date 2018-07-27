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


$app->group('/roles', function () use ($app) {
    // $app->get('/{id}', function ($request, $response, $args = null) {
    //     $name = $request->getAttribute('token');
    // });
    $app->get('/{id}', 'AgoraApiRolesController::get');
    $app->get('/{offset}/{limit}', 'AgoraApiRolesController::get');
    //$app->get('/{offset}[/{limit}]', 'AgoraApiRolesController::get');
});
