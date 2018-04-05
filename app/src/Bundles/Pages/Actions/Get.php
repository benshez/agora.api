<?php
/**
 * BaseGet File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseSave
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Pages\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Pages\Actions\Action;
use Agora\Bundles\Pages\Validation\Validation;

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
            array('enabled' => true)
        );
        
        return ($pages);        
    }
}
