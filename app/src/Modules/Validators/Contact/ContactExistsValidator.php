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

namespace Agora\Modules\Validators\Contact;

use Zend\Validator\AbstractValidator;
use Agora\Modules\Base\Interfaces\IBaseAction;

class ContactExistsValidator extends AbstractValidator
{
    const REFERENCE = 'contact';
    const CONTACT_EXISTS = 'user';

    protected $messageTemplates = array(
        self::CONTACT_EXISTS  => 'A user with this id already exists.'
    );

    /**
     * Ctor EmailExistsValidator
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

        $action = $this->getOption('action');

        $contact = $action->onBaseActionGet()->get(
            $action->getReference(self::REFERENCE),
            ['id' => $value]
        );

        $exists = $contact && ($contact->getId() === (int) $value);

        if ($exists) {
            $isValid = false;
        }

        if (!$isValid) {
            $this->error(self::CONTACT_EXISTS, $value);
        }

        return $isValid;
    }
}
