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

namespace Agora\Bundles\Industries\Controller;

use Agora\Bundles\Industries\Interfaces\IIndustriesController;
use Agora\Modules\Base\Controller\BaseController;
use Agora\Modules\Base\Options\BaseOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller extends BaseController implements IIndustriesController
{
    private $_options = [
        'part' => 'messages',
        'class' => 'industries',
        'extention' => 'validation:autocomplete:message:IndustriesNotFound',
    ];

    /**
     * Find Industry By Description
     *
     * @param RequestInterface  $request  Request Interface.
     *
     * @param ResponseInterface $response Response Interface.
     *
     * @param array             $args     Args.
     *
     * @return Industry
     */
    public function autoComplete(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $fetched = $this->fetched(
            $request,
            $response,
            $this->getAction()->autoComplete(
                $args
            ),
            new BaseOptions($this->_options)
        );

        if ($fetched) {
            return $fetched;
        }

        return false;
    }
}
