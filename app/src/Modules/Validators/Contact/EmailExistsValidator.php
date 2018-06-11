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

namespace Agora\Modules\Validators\Contact;

use Agora\Modules\Base\Interfaces\IBaseAction;
use Zend\Validator\AbstractValidator;

class EmailExistsValidator extends AbstractValidator
{
    const REFERENCE = 'contact';
    const EMAIL_EXISTS = 'email';

    protected $messageTemplates = [
        self::EMAIL_EXISTS => 'Email %value% already in use.',
    ];

    /**
     * Ctor EmailExistsValidator
     *
     * @param array       $options Validator options.
     *
     * @param IBaseAction $action  Action.
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
     * @param array $value Values.
     *
     * @return boolean
     */
    public function isValid($value)
    {
        $isValid = true;

        $action = $this->getOption('action');

        $contact = $action->onBaseActionGet()->get(
            $action->getReference(self::REFERENCE),
            ['email' => $value['email']]
        );

        $isValid = $contact && ($contact->getId() === (int) $value['id']);

        if (!$isValid) {
            $this->error(self::EMAIL_EXISTS, $value['email']);
        }

        return $isValid;
    }
}
