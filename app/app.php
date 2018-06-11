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
require_once __DIR__ . '/../vendor/autoload.php';

// Set up config

$config = new \Agora\Modules\Config\Config();

$settings = $config->getConfig();

$app = new \Slim\App($settings);

// Set up dependencies
require_once 'dependencies.php';

// Register middleware
require_once 'middleware.php';

$routes = $settings['settings']['routes']['routes'];

// Register routes
new \Agora\Modules\Routes\Routes($app, $routes);

$app->run();
