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

namespace Agora\Bundles\Entities\Actions;

use Agora\Bundles\Entities\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;

class Save extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'entities';
    const KEY = 'id';

    /**
     * Save Role
     *
     * @param array $args Role.
     *
     * @return Role
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

        $entity = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            [self::KEY => $args[self::KEY]]
        );

        $hydrate = new BaseHydrate($this->getContainer());

        $entity = $this->onBaseActionSave()->save(
            $hydrate->hydrate($entity, $args)
        );

        if (!$entity) {
            return false;
        }

        if ($entity->getId()) {
            $entity = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                [self::KEY => $entity->getId()]
            );

            return $entity;
        }

        return false;
    }
}
