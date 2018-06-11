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

namespace Agora\Bundles\Pages\Controller;

use Agora\Bundles\Pages\Interfaces\IPagesController;
use Agora\Modules\Base\Controller\BaseController;

class Controller extends BaseController implements IPagesController
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'pages';
}
