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

use Agora\Bundles\Contact\Entity\Contact;
use Agora\Bundles\Contact\Validation\Validation;
use Agora\Modules\Base\Actions\BaseAction;

class Action extends BaseAction
{
    const REFERENCE = 'contact';
    const EXISTS_MESSAGE = 'validation:add:message:UserExists';

    /**
     * Authenticate User.
     *
     * @param string $email    User Name.
     * @param string $password User Password.
     *
     * @return User
     */
    public function authenticate(string $email, string $password)
    {
        $user = new \Agora\Bundles\Contact\Actions\Get(
            $this->getContainer()
        );
        $authenticated = $user->authenticate($email, $password);

        return $authenticated;
    }

    /**
     * Save User.
     *
     * @param array $args User Password.
     *
     * @return User
     */
    public function onUpdate(array $args)
    {
        $save = new \Agora\Bundles\Contact\Actions\Save(
            $this->getContainer()
        );

        $contact = $save->onUpdate($args);

        return $contact;
    }

    /**
     * Add User.
     *
     * @param array $args User.
     *
     * @return User
     */
    public function onAdd(array $args)
    {
        $add = new \Agora\Bundles\Contact\Actions\Add(
            $this->getContainer()
        );

        $contact = $add->onAdd($args);

        return $contact;
    }

    /**
     * Delete User.
     *
     * @param array $args User ID.
     *
     * @return User
     */
    public function onDelete(array $args)
    {
        $delete = new \Agora\Bundles\Contact\Actions\Delete(
            $this->getContainer()
        );

        $contact = $delete->onDelete($args);

        return $contact;
    }

    public function emptyContact() {
        $contact = [
            'id' => '',
            'entity' => '',
            'role' => '',
            'enabled' => '',
            'locked' => '',
            'username' => '',
            'usersurname' => '',
            'address' => '',
            'city' => '',
            'state' => '',
            'post_code' => '',
            'phone' => '',
            'email' => '',
            'website' => '',
            'facebook' => '',
            'twitter' => '',
            'logo' => '',
            'abn' => '',
            'token_char' => '',
            'token_expiry' => '',
            'message' => '',
            'error' => ''
        ];

        return $contact;
    }
}
