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

namespace AgoraApi\Application\Core\Validation;

use AgoraApi\Application\Core\Interfaces\IValidator;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as Validation;

class Validator implements IValidator
{
    /**
     * The list of validation errors.
     *
     * @var string[]
     */
    protected $_errors;
    /**
     * @var AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration
     */
    protected $_parameters;

    protected $_validatorArray = [];

    public function __construct(
        AgoraApiConfiguration $parameters
    ) {
        $this->_parameters = $parameters;
        //$this->_parameters->getSetting('validation.showValidationRules');
        $this->_parameters->getSetting('validation.defaultMessages');
    }

    public function validate(array $data, array $rules)
    {
        foreach ($data as $key => $value) {
            try {
                $rules[$key]->assert($value);
            } catch (NestedValidationException $e) {
                $this->_errors[$key] = $e->getMessages();
            }
        }

        return $this;
    }

    public function getErrors()
    {
        return $this->_errors;
    }

    public function fails()
    {
        return !empty($this->_errors);
    }

    public function getIdValidator($id)
    {
        $this->_validatorArray = [];
        $this->setIdValidator($id);
        return $this->_validatorArray;
    }

    public function getOffsetValidator($offset, $limit)
    {
        $this->_validatorArray = [];
        $this->setOffsetValidator($offset, $limit);
        return $this->_validatorArray;
    }

    private function setIdValidator($id): void
    {
        $this->_validatorArray = [
            'validatorRules' => [
                'recordKey' => Validation::notEmpty()
                ->numeric()
                ->setName($this->_parameters->getValidatorName('recordKey'))
                ->setTemplate($this->_parameters->getValidatorTemplate('recordKey')),
            ],
            'validatorData' => [
                'recordKey' => $id,
            ],
        ];
    }

    private function setOffsetValidator($offset, $limit): void
    {
        $this->_validatorArray = [
            'validatorRules' => [
                'pagingOffset' => Validation::numeric()
                ->setName($this->_parameters->getValidatorName('pagingOffset'))
                ->setTemplate($this->_parameters->getValidatorTemplate('pagingOffset')),
                'pagingLimit' => Validation::numeric()
                ->between(0, 20)
                ->setName($this->_parameters->getValidatorName('pagingLimit'))
                ->setTemplate($this->_parameters->getValidatorTemplate('pagingLimit')),
            ],
            'validatorData' => [
                'pagingOffset' => $offset,
                'pagingLimit' => $limit,
            ],
        ];
    }
}
