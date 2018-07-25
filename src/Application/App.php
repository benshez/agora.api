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

namespace AgoraApi\Application;

use AgoraApi\Application\Helpers\AgoraApiArrayHelper;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use DI\ContainerBuilder;
use Slim\Exception\ContainerValueNotFoundException;

class App extends \DI\Bridge\Slim\App
{
    protected $_app;
    protected $_config;
    protected $_dotenv;
    protected $_builder;

    public function __construct()
    {
        $this->setConfig();
        $this->setApp();
        $this->setRoutes();
        $this->setMiddleware();
        parent::run();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $this->_dotenv->load();
        $this->_builder = $builder;
        $this->addDefinitions();
        $this->container = $this->_builder->build();
    }

    public function getApp()
    {
        return $this->_app;
    }

    public function getRoutes()
    {
        $this->setRoutes();
    }

    public function getConfig()
    {
        return $this->_config;
    }

    private function setApp(): void
    {
        if (null === $this->_app) {
            parent::__construct($this->getConfig()->getSettings());
            $this->_app = $this;
        }
    }

    private function setRoutes(): void
    {
        $config = $this->getConfig();
        $CI = $this;

        try {
            $this->getApp()->group('/api/' . $config->getRoutVersion(), function () use ($config, $CI) {
                $CI->requireItems($config->getVersionRouteRoot());
            });
        } catch (ContainerValueNotFoundException $exception) {
        }
    }

    private function setConfig(): void
    {
        if (null === $this->_config) {
            $this->_config = new AgoraApiConfiguration();
            $this->_dotenv = new \Dotenv\Dotenv($this->getConfig()->getAppRoot() . 'config');
        }
    }

    private function setMiddleware(): void
    {
        $app = $this->getApp();
        $container = $this->container;

        $app->add($container->get('AgoraApiHttpBasicAuthentication'));
        $app->add($container->get('AgoraApiCorsMiddleware'));
        $app->add($container->get('AgoraApiNegotiationMiddleware'));
        $app->add($container->get('AgoraApiJwtAuthentication'));
    }

    private function addDefinitions(): void
    {
        $helper = new AgoraApiArrayHelper();

        $helper->add_definitions_all($this->getConfig()->getConfigRoot() . DIRECTORY_SEPARATOR . 'containers' . DIRECTORY_SEPARATOR, $this->_builder);
    }

    private function requireItems($path): void
    {
        $helper = new AgoraApiArrayHelper();

        $helper->require_all($path, $this->getApp());
    }
}
