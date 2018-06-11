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

namespace Agora\Bundles\Roles\Actions;

use Agora\Bundles\Roles\Entity\Roles;
use Agora\Bundles\Roles\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;

class Add extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'roles';
    const KEY = 'id';

    /**
     * Add Roles
     *
     * @param array $args Industry.
     *
     * @return Roles
     */
    public function onAdd(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'add',
            $args
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();

            return $messages;
        }

        $role = new Roles();

        $hydrate = new BaseHydrate($this->getContainer());

        $role = $this->onBaseActionSave()->save(
            $hydrate->hydrate($role, $args)
        );

        if (!$role) {
            return false;
        }

        if ($role->getId()) {
            $role = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                [self::KEY => $role->getId()]
            );

            return $role;
        }

        return false;
    }
}
