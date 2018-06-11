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

namespace Agora\Bundles\Locations\Actions;

use Agora\Bundles\Locations\Validation\Validation;

class Delete extends Action
{
    const REFERENCE = 'locations';
    const REFERENCE_OBJECT = 'name';
    const KEY = 'id';

    /**
     * Delete Locations
     *
     * @param array $args Locations.
     *
     * @return Locations
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

        $location = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            [self::KEY => $args[self::KEY]]
        );

        if (!$location) {
            return false;
        }

        $this->onBaseActionDelete()->delete($location);

        return false;
    }
}
