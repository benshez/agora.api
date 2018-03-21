<?php
require 'vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\DBAL\Migrations;
use Doctrine\Common\ClassLoader;
use Agora\Modules\Config\Config;

$config = new \Agora\Modules\Config\Config();
$parameters = $config->getConfig();
$isDevMode = ($parameters['settings']['mode'] == 'development');
// the connection configuration
$dbParameters = $parameters['settings']['doctrine']['connection'];

$config = Setup::createYAMLMetadataConfiguration(
	array(__DIR__.'/../mapping/yaml'),
	$isDevMode
);

$entityManager = EntityManager::create($dbParameters, $config);

$helper = ConsoleRunner::createHelperSet($entityManager);

return ConsoleRunner::createHelperSet($entityManager);
