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

class Delete extends Action
{
    const KEY = 'id';

    const REFERENCE = 'contact';

    const REFERENCE_OBJECT = 'name';

    /**
     * Delete Industries.
     *
     *
     * @param  array      $args Industry.
     * @return Industry
     */
    public function onDelete(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'delete',
            $args
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();

            return $messages;
        }

        $contact = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            [self::KEY => $args]
        );

        if (!$contact) {
            return false;
        }

        if (!$contact->getEnabled()) {
            $this->onBaseActionDelete()->delete($contact);
        } else {
            $this->onBaseActionSave()->disable($contact);
        }

        return false;
    }
}
