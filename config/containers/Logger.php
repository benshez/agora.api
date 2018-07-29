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

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Container\ContainerInterface;

return [
    AgoraApiErrorLogger::class => function (ContainerInterface $container) {
        $config = $container->get(AgoraApiParameters::class);

        $logger = new Logger('AgoraApi');

        $formatter = new LineFormatter(
            "[%datetime%] [%level_name%]: %message% %context%\n",
            null,
            true,
            true
        );

        $rotating = new RotatingFileHandler($config->getSetting('logger.path') . DIRECTORY_SEPARATOR . $config->getSetting('appName') . '_Log', 0, Logger::DEBUG);
        $rotating->setFormatter($formatter);
        $logger->pushHandler($rotating);

        return $logger;
    },
];
