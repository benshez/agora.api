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

namespace Agora\Bundles\Contact\Actions;

use Agora\Bundles\Contact\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;
use Zend\Crypt\Password\Bcrypt;

class Save extends Action
{
    const REFERENCE = 'contact';
    const KEY = 'id';
    const PASSWORD = 'password';
    const ABN = 'abn';
    const EMAIL = 'email';

    /**
     * Save User.
     *
     * @param array $args User Password.
     *
     * @return User
     */
    public function onUpdate(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'update',
            $args
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();

            return $messages;
        }

        $contact = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            [self::KEY => $args[self::KEY]]
        );

        if ($contact && $contact->getId()) {
            if (isset($args[self::PASSWORD])) {
                $bcrypt = new Bcrypt();
                $password = $bcrypt->create($args[self::PASSWORD]);
                $args[self::PASSWORD] = $password;
            }

            $hydrate = new BaseHydrate($this->getContainer());

            $contact = $hydrate->hydrate($contact, $args);

            $contact = $this->onBaseActionSave()->save($contact);
        }

        if ($contact->getId()) {
            $contact = $this->contactToArray(
                $this->onBaseActionGet()->get(
                    $this->getReference(self::REFERENCE),
                    [self::KEY => $contact->getId()]
                )
            );

            return $contact;
        }

        return false;
    }

    /**
     * Update User Login Attemps.
     *
     * @param array $args User Password.
     */
    public function onUpdateLoginAttempts(array $args)
    {
    }
}
