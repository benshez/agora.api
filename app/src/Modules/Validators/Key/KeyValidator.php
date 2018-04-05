<?php
/**
 * EmailExistsValidator File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  EmailExistsValidator
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Modules\Validators\Key;

use Zend\Validator\Digits;
use Zend\Validator\AbstractValidator;
use Agora\Modules\Base\Interfaces\IBaseAction;

class KeyValidator extends AbstractValidator
{
    const NOT_VALID_KEY = 'key';

    protected $messageTemplates = array(
        self::NOT_VALID_KEY  => 'Not a valid %value% id supplied.'
    );
    
    /**
     * Ctor KeyValidator
     *
     * @param array $options Validator options.
     *
     * @return User
     */
    public function __construct(array $options = array())
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

        if ($value['id'] === null) {
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
