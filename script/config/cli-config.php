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
/**
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 *
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @see      https://github.com/benshez/agora.api
 */
require '../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

$dotenv = new Dotenv\Dotenv(__DIR__ . '/../../config');
$dotenv->load();

$config = new \AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration();
$parameters = $config->getSettings();
$isDevMode = true; //($parameters['settings']['mode'] === 'development');
// the connection configuration
$dbParameters = [
    'driver' => 'pdo_mysql',
    'user' => $_ENV['DOCTRINE_USERNAME'],
    'password' => $_ENV['DOCTRINE_PASSWORD'],
    'dbname' => $_ENV['DOCTRINE_DATABASE'],
    'host' => $_ENV['DOCTRINE_HOST'],
    'charset' => 'utf8',
    'port' => $_ENV['DOCTRINE_PORT'],
];

$config = Setup::createYAMLMetadataConfiguration(
    [__DIR__ . '/../../mapping/yaml'],
    $isDevMode
);

$entityManager = EntityManager::create($dbParameters, $config);

$helper = ConsoleRunner::createHelperSet($entityManager);

return ConsoleRunner::createHelperSet($entityManager);
