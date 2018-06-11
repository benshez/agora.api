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
require 'vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;

$config = new \Agora\Modules\Config\Config();
$parameters = $config->getConfig();
$isDevMode = ($parameters['settings']['mode'] === 'development');
// the connection configuration
$dbParameters = $parameters['settings']['doctrine']['connection'];

$config = Setup::createYAMLMetadataConfiguration(
    [__DIR__ . '/../mapping/yaml'],
    $isDevMode
);

$entityManager = EntityManager::create($dbParameters, $config);

$helper = ConsoleRunner::createHelperSet($entityManager);

return ConsoleRunner::createHelperSet($entityManager);
