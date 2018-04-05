<?php
/**
 * BaseGet File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  Config
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Modules\Config;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;
use Zend\Config\Factory;
use Zend\Config\Reader\Yaml as YamlConfig;

class Config
{
    const PARAMETER_FILE_PATH = '/../../../../config/environments/';
    const PARAMETER_FILE = 'parameters.yaml';
    const PARAMETER_ENVIRONMENT_FILE = 'parameters.%s.yaml';
    const PARAMETER_SETTINGS = 'settings';
    const PARAMETER_ROUTES = 'routes';
    const PARAMETER_VERSION = 'version';
    const PARAMETER_ENVIRONMENT = 'mode';
    
    private $_path = __DIR__ .self::PARAMETER_FILE_PATH;
    private $_settings = null;
    private $_environment = null;
    private $_version = null;
    private $_reader = null;

    /**
     * Ctor
     *
     * @param \Slim\Collection $settings Setting.
     *
     * @return void
     */
    public function __construct(\Slim\Collection $settings = null)
    {
        if ($settings != null) {
            $this->_settings = $settings;
        }
    }
        
    /**
     * Config
     *
     * @return Settings
     */
    public function getConfig()
    {
        $this->_createReader();
        
        $this->_setEnvironment();

        $this->_addSettings();
        
        $this->_addVersion();
        
        $this->_addRoutes();
        
        return $this->_settings;
    }
   
    /**
     * Create Yaml Reader
     *
     * @return void
     */
    private function _createReader()
    {
        if (null === $this->_reader) {
            $this->_reader = new YamlConfig(
                [\Symfony\Component\Yaml\Yaml::class, 'parse']
            );
        }
    }
    
    /**
     * Add Settings
     *
     * @return void
     */
    private function _addSettings()
    {
        $path = $this->_path;
        $path .= $this->getEnviroment();
        $path .= '/';
        $path .= self::PARAMETER_FILE;

        $this->_settings[self::PARAMETER_SETTINGS] =
        $this->_reader->fromFile($path);
    }

    /**
     * Add Version
     *
     * @return void
     */
    private function _addVersion()
    {
        $this->_settings[self::PARAMETER_SETTINGS][self::PARAMETER_VERSION] =
        $this->getVersion();
    }
    
    /**
     * Add Routes
     *
     * @return void
     */
    private function _addRoutes()
    {
        $path = $this->_path;
        $path .= $this->getEnviroment();
        $path .= '/';
        $path .= self::PARAMETER_ROUTES;
        $path .= '/';
        $path .= $this->getVersion();
        $path .= '/';
        $path .= sprintf(
            self::PARAMETER_ENVIRONMENT_FILE,
            self::PARAMETER_ROUTES
        );
        
        $this->_settings[self::PARAMETER_SETTINGS][self::PARAMETER_ROUTES] =
        $this->_reader->fromFile($path);
    }

    /**
     * Set Environment
     *
     * @return void
     */
    private function _setEnvironment()
    {
        $environment = $this->_reader->fromFile(
            $this->_path.self::PARAMETER_FILE
        );
        
        $this->_environment = $environment;
    }
    
    /**
     * Get Version
     *
     * @return Version
     */
    public function getVersion()
    {
        $verion = $this->_environment;
        
        return $verion[self::PARAMETER_VERSION];
    }
    
    /**
     * Get Enviroment
     *
     * @return Enviroment
     */
    public function getEnviroment()
    {
        $environment = $this->_environment;
        
        return $environment[self::PARAMETER_ENVIRONMENT];
    }
    
    /**
     * Config Setting
     *
     * @param \Slim\Collection $settings Setting.
     *
     * @param string           $path     Path.
     *
     * @return Setting
     */
    public function getConfigSetting(\Slim\Collection $settings, string $path)
    {
        $path = explode(':', $path);

        foreach ($path as $key => $part) {
            $settings = $settings[$part];
        }

        return $settings;
    }
    
    /**
     * Options Paths
     *
     * @return Paths
     */
    public function getOptionsPaths()
    {
        $paths = array(
            'name' => 'entities:%s:name',
            'arguments' => 'entities:%s:arguments:',
            'validators' => 'entities:%s:methods:validation:',
            'messages' => 'entities:%s:messages:'
        );
        
        return $paths;
    }

    /**
     * Get Config Option
     *
     * @param string $option    Option.
     *
     * @param string $class     Class.
     *
     * @param string $extention Extention.
     *
     * @return Current Time
     */
    public function getOption(string $option, string $class, string $extention = '')
    {
        $opt = $this->getConfigSetting(
            $this->getSettings(),
            sprintf($this->getOptionsPaths()[$option], $class).$extention
        );
        
        return $opt;
    }

    /**
     * Today Formatted To Year Month Day
     *
     * @return Today Formatted
     */
    public static function currentDateYearMonthDay()
    {
        $currDate = date('Y-m-d');
        
        return $currDate;
    }
 
    /**
     * Current Time Zone
     *
     * @return Current Time Zone
     */
    public function getDateTimeForZone()
    {
        $timeZone = new \DateTime(
            'now',
            new \DateTimeZone(
                $this->_settings['time_zone']
            )
        );
        
        return $timeZone;
    }

    /**
     * Future Date For Zone
     *
     * @param string $days Days Ahead.
     *
     * @return Current Time Zone
     */
    public function getDateTimeFuture(string $days)
    {
        $future = $this->getDateTimeForZone()->add(
            new \DateInterval('P'.$days.'D')
        );
        
        return $future;
    }

    /**
     * Get Settings
     *
     * @return Settings
     */
    private function getSettings()
    {
        $settings = $this->_settings;
        
        return $settings;
    }
}
