<?php
/**
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

// e.g: $app->add(new \Slim\Csrf\Guard);

$container = $app->getContainer();

$app->add(
    new \Tuupola\Middleware\Cors(
        $settings['settings']['cors']
    )
);
