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

namespace Agora\Bundles\Roles\Controller;

use Agora\Bundles\Roles\Interfaces\IRolesController;
use Agora\Modules\Base\Controller\BaseController;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Controller extends BaseController implements IRolesController
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'roles';
    const KEY = 'id';

    /**
     * Get Roles
     *
     * @param RequestInterface  $request  Request Interface.
     *
     * @param ResponseInterface $response Response Interface.
     *
     * @param array             $args     Roles.
     *
     * @return Roles
     */
    public function onFetch(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $roles = $this->getAction()->onBaseActionGet(
            $this->getAction()->getReference(self::REFERENCE),
            $args
        );

        return $roles;
    }
}
