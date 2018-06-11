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

namespace Agora\Bundles\Locations\Interfaces;

use Agora\Modules\Base\Interfaces\IBaseController;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ILocationsController extends IBaseController
{
    /**
     * Find Locations By Industry Code
     *
     * @param RequestInterface  $request  Request Interface.
     *
     * @param ResponseInterface $response Response Interface.
     *
     * @param array             $args     Args.
     *
     * @return Locations
     */
    public function findLocationsByIndustryCode(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    );
}
