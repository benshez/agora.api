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

namespace Agora\Bundles\Contact\Controller;

use Agora\Bundles\Contact\Interfaces\IContactController;
use Agora\Modules\Base\Controller\BaseController;
use Agora\Modules\Base\Options\BaseOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller extends BaseController implements IContactController
{
    private $_options = [
        'part' => 'messages',
        'class' => 'contact',
        'extention' => 'validation:authenticate:message:UserNotFound',
    ];

    /**
     * Authenticate Contact.
     *
     *
     *
     *
     * @param  RequestInterface  $request  Request.
     * @param  ResponseInterface $response Response.
     * @param  array             $args     Arguments.
     * @return boolean
     */
    public function authenticateOne(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $fetched = $this->fetched(
            $request,
            $response,
            $this->getAction()->authenticate(
                $request->getParam('email'),
                $request->getParam('password')
            ),
            new BaseOptions($this->_options)
        );

        if ($fetched) {
            return $fetched;
        }

        return false;
    }
}
