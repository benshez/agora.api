<?php

namespace Agora\Bundles\Locations\Validation;

use Zend\Crypt\Password\Bcrypt;
use Agora\Modules\Base\Validation\BaseValidation;

class Validation extends BaseValidation
{
    public function validateIndustryCodeInput($value)
    {
        $this->validator
        ->attachByName('NotEmpty', [], true)
        ->attachByName('StringLength', ['min' => 1], true);
    }
}
