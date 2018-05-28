<?php

/**
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 * @package   Agora
 *
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Contact\Actions;

use Agora\Bundles\Contact\Validation\Validation;
use Agora\Modules\Config\Config;

class Get extends Action
{
    const ABN = 'abn';

    const AUTHENTICATE = 'authenticate';

    const AUTHENTICATION = 'authentication';

    const CONTACT_NAME = 'username';

    const CONTACT_SURNAME = 'usersurname';

    const EMAIL = 'email';

    const HASH = 'hash';

    const KEY = 'id';

    const LOGO = 'logo';

    const PASSWORD = 'password';

    const REFERENCE = 'contact';

    const REFERENCE_OBJECT = 'name';

    const ROLE = 'role';

    const TOKEN = 'tokenChar';

    const USER = 'user';

    /**
     * Authenticate User.
     *
     *
     * @param  string $email    User Name.
     * @param  string $password User Password.
     * @return User
     */
    public function authenticate(
        string $email,
        string $password
    ) {
        $validator = new Validation($this);
        $valid = $this->getValidator($validator);

        if (!$this->formIsValid(
            $valid,
            self::REFERENCE,
            self::AUTHENTICATE,
            [self::EMAIL => $email, self::PASSWORD => $password]
        )) {
            $message = $valid->getMessagesAray();
            $contact = $this->emptyContact();
            $contact['error'] = $message['error'];
            $contact['message'] = $message['message'];

            $eventManager = $this->getEntityManager()->getEventManager();
            $eventManager->dispatchEvent(\Agora\Modules\Mailer\MailerListener::ON_SEND_ACTIVATION, new \Doctrine\Common\Persistence\Event\LifecycleEventArgs($contact, $this->getEntityManager()));

            return $this->onSerialize($contact);
        }

        $contact = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            [self::EMAIL => $email]
        );

        if ($contact) {
            $tokenGenerator = new \Doctrine\ORM\Id\UuidGenerator();

            $tokenChar = $tokenGenerator->generate(
                $this->getEntityManager(),
                $contact
            );

            $contact->setTokenChar($tokenChar);

            $contact->setPassword('');

            return $this->onSerialize($contact);
        }

        return false;
    }

    /**
     * Get Active User Role By Token.
     *
     *
     * @param  string $token Token Genrated When User Logs In.
     * @return User   Role
     */
    public function onGetActiveUserRoleByToken(string $token)
    {
        $user = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            [self::TOKEN => $token]
        );

        if (!$user ||
            $user->getTokenExpiry() > Config::currentDateYearMonthDay()
        ) {
            return false;
        }

        if ($user->getLocked() || !$user->getEnabled()) {
            return false;
        }

        $role = $user->getRole()->getRole();

        return $role;
    }
}
