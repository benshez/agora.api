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

        $cache = ('' === $parameters->getSetting('doctrine.meta.cache')) ? new ArrayCache() : $parameters->getSetting('doctrine.meta.cache');

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

        $dbConfig = include $parameters->getSetting('doctrine.envConfigPath');

        $entityManager = EntityManager::create(
            $dbConfig,
            $config,
            $container->get(AgoraApiEventManager::class)
        );

        $platform = $entityManager->getConnection()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        return $entityManager;
    },

    AgoraApiEventManager::class => function (ContainerInterface $container) {
        $eventManager = new \Doctrine\Common\EventManager();

        $listener = new \AgoraApi\Infrastructure\Listeners\MailListener(
            $container->get('errorHandler'),
            $container->get('AgoraApiParameters'),
            $container->get('AgoraApiMailService')
        );

        $eventManager->addEventListener($listener->getSubscribedEvents(), $listener);
        //$eventManager->addEventSubscriber(new \Agora\Modules\Base\Events\BaseEventSubscriber());
        return $eventManager;
    },
];
