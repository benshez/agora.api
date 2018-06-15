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
// $file = __DIR__ .'/../config/environments/development/parameters.xml';

// $objDOM = new DOMDocument();

// //Load xml file into DOMDocument variable
// $objDOM->load($file);
// $objDOM->xinclude();
// //Find Tag element "config" and return the element to variable $node
// $node = $objDOM->getElementsByTagName("doctrine");

// foreach ($node as $searchNode) {
//     $dbHost = $searchNode->getAttribute('connection');
//     $dbUser = $searchNode->getAttribute('userdb');
//     $dbPass = $searchNode->getAttribute('dbpass');
//     $dbDatabase = $searchNode->getAttribute('database');
// }

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
