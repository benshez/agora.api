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

namespace Agora\Modules\Validators\Key;

use Zend\Validator\AbstractValidator;
use Zend\Validator\Digits;

class KeyValidator extends AbstractValidator
{
    const NOT_VALID_KEY = 'key';

    protected $messageTemplates = [
        self::NOT_VALID_KEY => 'Not a valid %value% id supplied.',
    ];

    /**
     * Ctor KeyValidator
     *
     * @param array $options Validator options.
     *
     * @return User
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * IsValid
     *
     * @param $value Values.
     *
     * @return boolean
     */
    public function isValid($value)
    {
        $isValid = true;

        if (null === $value['id']) {
            $isValid = true;
        } else {
            $validator = new Digits();
            $isValid = $validator->isValid($value['id']);
        }

        if (!$isValid) {
            $this->error(self::NOT_VALID_KEY, $value['entity']);
        }

        return $isValid;
    }
}
