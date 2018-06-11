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

use Agora\Bundles\Locations\Entity\Locations;
use Agora\Bundles\Locations\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;

class Add extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'locations';
    const KEY = 'id';
    const PASSWORD = 'password';
    const ABN = 'abn';
    const EMAIL = 'email';

    /**
     * Save Location
     *
     * @param array $args Location.
     *
     * @return Location
     */
    public function onAdd(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'add',
            $args['location']
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();

            return $messages;
        }

        $location = new Locations();

        $hydrate = new BaseHydrate($this->getContainer());

        $user = $this->onBaseActionGet()->get(
            $this->getReference('contact'),
            ['id' => $args['user']['id']]
        );

        if ($user && $user->getEnabled()) {
            $location->setUser($user);

            $location = $this->onBaseActionSave()->save(
                $hydrate->hydrate($location, $args['location'])
            );
        } else {
            $location = false;
        }

        if (!$location) {
            return false;
        }

        if ($location->getId()) {
            $location = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                [self::KEY => $location->getId()]
            );

            return $location;
        }

        return false;
    }
}
