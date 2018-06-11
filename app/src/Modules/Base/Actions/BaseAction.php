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

namespace Agora\Modules\Base\Actions;

use Agora\Modules\Base\Interfaces\IBaseAction;
use Agora\Modules\Config\Config;
use Interop\Container\ContainerInterface;
use ReflectionObject;

class BaseAction implements IBaseAction
{
    const ENTITY_MANAGER = 'em';

    const REFERENCE_OBJECT = 'name';

    const SETTINGS = 'settings';

    const VALIDATORS = 'validators';

    private $_baseDelete;

    private $_baseGet;

    private $_baseReference;

    private $_baseSave;

    private $_config;

    private $_container;

    private $_manager;

    private $_settings;

    private $_validator;

    /**
     * Initialise BaseAction To Set Container
     *
     * @param  ContainerInterface $container containerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * Get FormIsValid
     *
     * @param  ReflectionObject $validator validator
     * @param  string           $class     class
     * @param  string           $extention class Extention
     * @param  array            $args      args
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

        $values = [];

        foreach ($fields as $key => $field) {
            foreach ($field as $value) {
                if (isset($value[3]) && is_array($value[3])) {
                    $val = [];
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
     * Get ContainerInterface
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->_container;
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
     * Base Get Offset And Limit
     *
     * @param  int $offset offset
     * @param  int $limit  limit
     * @return array
     */
    public function getOffsetAndLimit(
        int $offset = 0,
        int $limit = 10
    ) {
        $offset = ($offset <= 0) ? 1 : $offset;
        $limit = $limit ?? 10;
        $offset = ($limit * ($offset - 1));

        return ['offset' => $offset, 'limit' => $limit];
    }

    /**
     * Base Get Reference
     *
     * @param  string          $reference reference
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
     * Validator
     *
     * @param  \ReflectionObject $validatorClass class
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
     * Base Serliaze
     *
     * @param  \ReflectionObject $data class
     * @return array
     */
    public function onSerialize($data)
    {
        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();

        return $serializer->serialize($data, 'json');
    }

    /**
     * Set ContainerInterface
     *
     * @param  ContainerInterface $container containerInterface
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->_container = $container;
        $this->setEntityManager();
    }

    /**
     * Set ContainerInterface
     */
    public function setEntityManager()
    {
        $this->_manager = $this->_container->get(self::ENTITY_MANAGER);
    }
}
