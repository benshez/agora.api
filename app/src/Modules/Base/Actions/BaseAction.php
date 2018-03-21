<?php
/**
 * BaseAction File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseAction
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Modules\Base\Actions;

use \ReflectionObject;
use Agora\Modules\Config\Config;
use Interop\Container\ContainerInterface;
use Agora\Modules\Base\Interfaces\IBaseAction;

class BaseAction implements IBaseAction
{
    const SETTINGS = 'settings';
    const ENTITY_MANAGER = 'em';
    const VALIDATORS = 'validators';
    const REFERENCE_OBJECT = 'name';
    
    private $_validator = null;
    private $_container = null;
    private $_manager = null;
    private $_config = null;
    private $_settings = null;
    private $_baseReference = null;
    private $_baseGet = null;
    private $_baseSave = null;
    private $_baseDelete = null;
    
    /**
     * Initialise BaseAction To Set Container
     *
     * @param ContainerInterface $container ContainerInterface.
     *
     * @return void
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }
    
    /**
     * Get ContainerInterface
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->_container;
    }
    
    /**
     * Set ContainerInterface
     *
     * @param ContainerInterface $container ContainerInterface.
     *
     * @return void
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->_container = $container;
        $this->setEntityManager();
    }

    /**
     * Get EntityManager
     *
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->_manager;
    }

    /**
     * Set ContainerInterface
     *
     * @return void
     */
    public function setEntityManager()
    {
        $this->_manager = $this->_container->get(self::ENTITY_MANAGER);
    }

    /**
     * Get Config
     *
     * @return Config
     */
    public function getConfig()
    {
        $this->_config = (null === $this->_config) ?
        new Config($this->getSettings()) :
        $this->_config;
        return $this->_config;
    }

    /**
     * Get Settings
     *
     * @return Settings
     */
    public function getSettings()
    {
        $this->_settings = (null === $this->_settings) ?
        $this->getContainer()->get(self::SETTINGS) :
        $this->_settings;
        return $this->_settings;
    }
    
    /**
     * Base Get
     *
     * @return BaseGet
     */
    public function onBaseActionGet()
    {
        $this->_baseGet = (null === $this->_baseGet) ?
        new \Agora\Modules\Base\Actions\BaseGet(
            $this->getContainer()
        ) :
        $this->_baseGet;
        
        return $this->_baseGet;
    }
    
    /**
     * Base Save
     *
     * @return BaseSave
     */
    public function onBaseActionSave()
    {
        $this->_baseSave = (null === $this->_baseSave) ?
        new \Agora\Modules\Base\Actions\BaseSave(
            $this->getContainer()
        ) :
        $this->_baseSave;
        
        return $this->_baseSave;
    }
  
    /**
     * Base Delete
     *
     * @return BaseDelete
     */
    public function onBaseActionDelete()
    {
        $this->_baseDelete = (null === $this->_baseDelete) ?
        new \Agora\Modules\Base\Actions\BaseDelete(
            $this->getContainer()
        ) :
        $this->_baseDelete;
        
        return $this->_baseDelete;
    }
    /**
     * Get FormIsValid
     *
     * @param ReflectionObject $validator Validator.
     * @param string           $class     Class.
     * @param string           $extention Class Extention.
     * @param array            $args      Args.
     *
     * @return IsValid
     */
    public function formIsValid(
        $validator,
        string $class,
        string $extention,
        array $args
    ) {
    
        $fields = $this->getConfig()
            ->getOption(self::VALIDATORS, $class, $extention);
        
        $values = array();

        foreach ($fields as $key => $field) {
            foreach ($field as $value) {
                if (isset($value[3]) && is_array($value[3])) {
                    $val = array();
                    foreach ($value[3] as $index => $passed) {
                        $val[$passed] = $args[$passed];
                    }
                    $values[] = $val;
                } else {
                    $values[] = $args[$key];
                }
            }
        }

        $isValid = $validator->formIsValid(
            $fields,
            $values
        );
        
        return $isValid;
    }
    
    /**
     * Validator
     *
    * @param \ReflectionObject $validatorClass Class.
     *
     * @return validator
     */
    public function getValidator($validatorClass)
    {
        $this->_validator = (!$this->_validator) ?
        $validatorClass :
        $this->_validator;
        
        return $this->_validator;
    }
    
    /**
     * Base Get Reference
     *
     * @param string $reference Reference.
     *
     * @return BaseReference
     */
    public function getReference(string $reference)
    {
        $this->_baseReference = $this->getConfig()->getOption(
            self::REFERENCE_OBJECT,
            $reference
        );

        return $this->_baseReference;
    }
    
    /**
     * Base Get Offset AndL imit
     *
     * @param integer $offset Offset.
     *
     * @param integer $limit  Limit.
     *
     * @return array
     */
    public function getOffsetAndLimit(int $offset = 0, int $limit = 10)
    {
        $offset = ($offset <= 0) ? 1 : $offset;
        $limit = isset($limit) ? $limit : 10;
        $offset = ($limit * ($offset - 1));
        
        return array('offset' => $offset, 'limit' => $limit);
    }
}
