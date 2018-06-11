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

namespace Agora\Bundles\Industries\Actions;

use Agora\Bundles\Industries\Validation\Validation;

class Get extends Action
{
    const REFERENCE = 'industries';
    const REFERENCE_OBJECT = 'name';
    const DESCRIPTION = 'description';

    /**
     * Find Industries
     *
     * @param array $args Industry.
     *
     * @return Industry
     */
    public function autoComplete(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'autocomplete',
            [
                self::DESCRIPTION => $args[self::DESCRIPTION],
            ]
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();

            return $messages;
        }

        $industry = $this->getEntityManager()
            ->getRepository(
                $this->getConfig()->getOption(
                    'name',
                    self::REFERENCE
                ),
                [
                    [
                        self::DESCRIPTION => $args[self::DESCRIPTION],
                    ],
                ]
            )
            ->findAllByDescription(
                [
                    self::DESCRIPTION => $args[self::DESCRIPTION],
                ]
            );

        return $industry;
    }
}
