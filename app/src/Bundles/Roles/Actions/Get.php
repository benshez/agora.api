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

use Agora\Bundles\Roles\Validation\Validation;

class Get extends Action
{
    const REFERENCE = 'roles';
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

        $finder = new \Agora\Modules\Base\Entity\BaseEntity(
            $this->getEntityManager(),
            $this->getEntityManager()->getClassMetadata(
                $this->getReference(self::REFERENCE)
            )
        );

        $range = $this->getOffsetAndLimit(0, $args['offset']);

        $roles = $finder->findBy(
            isset($args[self::KEY]) ?
            [self::KEY => $args[self::KEY]] :
            [],
            null,
            $range['limit'],
            $range['offset']
        );

        if (!isset($args['sender'])) {
            return $this->onSerialize($roles);
        }

        return $roles;
    }
}
