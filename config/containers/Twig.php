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

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

return [
    AgoraApiTwig::class => function (ContainerInterface $container) {
        $config = $container->get(AgoraApiParameters::class);

        $view = new Twig($config->getAppRoot() . 'templates', [
            'cache' => false,
            'debug' => true,
        ]);

        // Instantiate and add Slim specific extension
        $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
        $view->addExtension(new TwigExtension($container->get('router'), $basePath));
        $view->addExtension(new Twig_Extension_Debug());

        $view->getEnvironment()->addGlobal('domain', $config->getSetting('mail.emailDomain'));

        return $view;
    },
];
