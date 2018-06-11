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

namespace Agora\Bundles\Locations\Controller;

use Agora\Bundles\Locations\Interfaces\ILocationsController;
use Agora\Modules\Base\Controller\BaseController;
use Agora\Modules\Base\Options\BaseOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller extends BaseController implements ILocationsController
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'locations';

    private $_options = ['part' => 'messages',
        'class' => self::REFERENCE,
        'extention' => 'validation:locations:message:IndustriesNotFound',
    ];

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
    ) {
        $fetched = $this->fetched(
            $request,
            $response,
            $this->getAction()->onGet($args),
            new BaseOptions($this->_options)
        );

        if ($fetched) {
            return $fetched;
        }

        return false;
    }
}
