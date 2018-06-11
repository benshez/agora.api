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

namespace Agora\Bundles\Options\Actions;

use Agora\Bundles\Options\Validation\Validation;

class Get extends Action
{
    const REFERENCE = 'options';
    const REFERENCE_OBJECT = 'name';
    const KEY = 'id';

    /**
     * Get Roles
     *
     * @param array $args Role.
     *
     * @return Role
     */
    public function onGet(array $args)
    {
        if (isset($args[self::KEY])) {
            $validator = new Validation($this);

            if (!$this->formIsValid(
                $this->getValidator($validator),
                self::REFERENCE,
                'get',
                [
                    self::KEY => $args[self::KEY],
                    'entity' => 'role',
                ]
            )) {
                $messages = $this->getValidator($validator)->getMessagesAray();

                return $messages;
            }
        }

        return false;
    }
}
