<?php

namespace Agora\Modules\Base\Interfaces;

use Zend\Validator\ValidatorChain;
use Agora\Modules\Base\Interfaces\IBaseAction;

interface IBaseValidation
{
    public function __construct(IBaseAction $action);
    public function setAction(IBaseAction $action);
    public function getAction();
    public function setMessagesArray($error = null, $class = null, $key = null);
    public function getMessagesAray();
    public function isValid($value);
    public function formIsValid(array $fields, array $values);
    public function create();
    public function createValidators(array $fields, array $values);
    public function dispose();
}
