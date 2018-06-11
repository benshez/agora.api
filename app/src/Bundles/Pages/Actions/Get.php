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

namespace Agora\Bundles\Pages\Actions;

class Get extends Action
{
    const REFERENCE = 'pages';
    const REFERENCE_OBJECT = 'name';

    /**
     * Get Pages
     *
     * @param array $args Pages.
     *
     * @return Pages
     */
    public function onGet(array $args)
    {
        $pages = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            ['enabled' => true]
        );

        return $pages;
    }
}
