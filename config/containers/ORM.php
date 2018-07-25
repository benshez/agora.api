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

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;

return [
    AgoraApiEntityManager::class => function (ContainerInterface $container) {
        $parameters = $container->get(AgoraApiParameters::class);

        $entityManager = null;

        $cache = ('' === $parameters->getSetting('doctrine.meta.cache')) ? new ArrayCache() : ('' === $parameters->getSetting('doctrine.meta.cache'));
        //$cache = new ArrayCache();
        $config = Setup::createAnnotationMetadataConfiguration(
            $parameters->getSetting('doctrine.paths'),
            false,
            $parameters->getSetting('doctrine.meta.proxy_dir'),
            $cache,
            $parameters->getSetting('doctrine.useSimpleAnnotationReader')
        );


        $config->setMetadataCacheImpl($cache);
        $config->setQueryCacheImpl($cache);
        $config->setAutoGenerateProxyClasses(true);


        // $file = $config->getConfigRoot() . DIRECTORY_SEPARATOR . 'doctrine' . DIRECTORY_SEPARATOR . 'doctrine.php';
        // $dbConfig = include $file;

        $dbConfig = [
            'driver' => 'pdo_mysql',
            'user' => $_ENV['DOCTRINE_USERNAME'],
            'password' => $_ENV['DOCTRINE_PASSWORD'],
            'dbname' => $_ENV['DOCTRINE_DATABASE'],
            'host' => $_ENV['DOCTRINE_HOST'],
            'charset' => 'utf8',
            'port' => $_ENV['DOCTRINE_PORT'],
        ];

        $entityManager = EntityManager::create($dbConfig, $config);
        $platform = $entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        return $entityManager;
    },
];
