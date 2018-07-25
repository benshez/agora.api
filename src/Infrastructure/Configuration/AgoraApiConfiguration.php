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

namespace AgoraApi\Infrastructure\Configuration;

use AgoraApi\Application\Helpers\AgoraApiArrayHelper;
use Slim\Collection;
use Zend\Config\Factory;

class AgoraApiConfiguration
{
    private $_app_root;
    private $_config_root;
    private $_environment;
    private $_version;
    private $_settings;
    private $_route;
    private $_route_version;
    /*
    * Var Factory
    */
    private $_reader;

    public function __construct(Collection $settings = null)
    {
        $this->getSettings();
    }

    public function getReader()
    {
        $this->setReader();
        return $this->_reader;
    }

    public function setReader()
    {
        if (null === $this->_reader) {
            $this->_reader = new Factory();
        }
    }

    public function getSettings()
    {
        $this->setSettings();
        return $this->_settings;
    }

    public function getSetting($key)
    {
        $helper = new AgoraApiArrayHelper();
        return $helper->data_get($this->_settings['settings'], $key);
    }

    public function setSettings(Collection $settings = null)
    {
        if (null === $settings) {
            $path = $this->getEnvironmentsRoot();
            $path .= $this->getEnvironment();
            $path .= DIRECTORY_SEPARATOR . '*.json';

            $this->_settings['settings'] = $this->getReader()->fromFiles(glob($path));
        } else {
            $this->_settings = $settings;
        }

        $helper = new AgoraApiArrayHelper();

        $this->_settings = $helper->str_replace_deep('{{__DIR__}}', $this->getAppRoot(), $this->_settings);
    }

    public function getEnvironment()
    {
        $this->setEnvironment();
        return $this->_environment;
    }

    public function setEnvironment()
    {
        $environment = $this->getReader()->fromFile(
            $this->getEnvironmentsRoot() . 'parameters.json'
        );

        $this->_environment = $environment['mode'];
    }

    public function getConfigRoot()
    {
        $this->setConfigRoot();
        return $this->_config_root;
    }

    public function setConfigRoot()
    {
        $this->_config_root = $this->getAppRoot();
        $this->_config_root .= 'config' . DIRECTORY_SEPARATOR;
    }

    public function getEnvironmentsRoot()
    {
        return $this->getConfigRoot() . 'environments' . DIRECTORY_SEPARATOR;
    }

    public function getAppRoot()
    {
        $this->setAppRoot();
        return $this->_app_root;
    }

    public function setAppRoot()
    {
        $this->_app_root = dirname(dirname(dirname(dirname(__FILE__))));
        $this->_app_root .= DIRECTORY_SEPARATOR;
    }

    public function getRoutVersion()
    {
        $this->setRoutVersion();
        return $this->_route_version;
    }

    public function getVersionRouteRoot()
    {
        return $this->getAppRoot() . 'routes' . DIRECTORY_SEPARATOR . $this->getRoutVersion() . DIRECTORY_SEPARATOR;
    }

    public function getValidatorName($key)
    {
        return $this->getSetting(
            sprintf('validation.defaultMessages.%s.name', $key)
        );
    }

    public function getValidatorTemplate($key)
    {
        return $this->getSetting(
            sprintf('validation.defaultMessages.%s.template', $key)
        );
    }

    private function setRoutVersion()
    {
        $this->getRoute();
        $this->_route_version = isset($this->_route[1]) ? $this->_route[1] : '';
    }

    private function getRoute()
    {
        $this->setRoute();
        return $this->_route;
    }

    private function setRoute()
    {
        $this->_route = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
    }
}
