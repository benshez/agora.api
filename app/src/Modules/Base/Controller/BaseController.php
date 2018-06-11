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

namespace Agora\Modules\Base\Controller;

use Agora\Modules\Base\Interfaces\IBaseAction;
use Agora\Modules\Base\Interfaces\IBaseController;
use Agora\Modules\Base\Options\BaseOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class BaseController implements IBaseController
{
    private $_parameters = [];
    private $_action = [];

    /**
     * Base Controller
     *
     * @param IBaseAction $action Action.
     */
    public function __construct(IBaseAction $action)
    {
        $this->setAction($action);
    }

    /**
     * Set Action
     *
     * @param IBaseAction $action Action.
     */
    public function setAction(IBaseAction $action)
    {
        $this->_action = $action;
    }

    /**
     * Get Action
     *
     * @return action
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Fetch
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param                   $sender   Sender.
     *
     * @param array             $args     Arguments.
     *
     * @param BaseOptions       $options  Arguments.
     *
     * @return boolean
     */
    public function fetch(
        RequestInterface $request,
        ResponseInterface $response,
        $sender,
        $args,
        BaseOptions $options
    ) {
        $data = $this->fetched(
            $request,
            $response,
            $this->getAction()->get($sender, $args),
            $options
        );

        return $data;
    }

    /**
     * Fetch
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param                   $sender   Sender.
     *
     * @param array             $args     Arguments.
     *
     * @param BaseOptions       $options  Arguments.
     *
     * @return boolean
     */
    public function fetchOne(
        RequestInterface $request,
        ResponseInterface $response,
        $sender,
        $args,
        BaseOptions $options
    ) {
        $data = $this->fetched(
            $request,
            $response,
            $this->getAction()->get($sender, $args),
            $options
        );

        return $data;
    }

    /**
     * Authenticate Contact
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param                    $args     Arguments.
     *
     * @param BaseOptions       $options  Arguments.
     *
     * @return boolean
     */
    public function fetched(
        RequestInterface $request,
        ResponseInterface $response,
        $args,
        BaseOptions $options
    ) {
        if ($args) {
            $data = $response->withJSON($args);

            return $data;
        }

        $data = $response->withStatus(
            404,
            $this->getAction()->getConfig()->getOption(
                $options->getOption('part'),
                $options->getOption('class'),
                $options->getOption('extention')
            )
        );

        return $data;
    }

    /**
     * Authenticate Contact
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param array             $args     Arguments.
     *
     * @return boolean
     */
    public function onGet(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $data = $response->withJSON(
            $this->getAction()->onGet($args)
        );

        return $data;
    }

    /**
     * Authenticate Contact
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param array             $args     Arguments.
     *
     * @return boolean
     */
    public function onAdd(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $data = $response->withJSON(
            $this->getAction()->onAdd($request->getParsedBody())
        );

        return $data;
    }

    /**
     * Authenticate Contact
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param array             $args     Arguments.
     *
     * @return boolean
     */
    public function onUpdate(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $data = $response->withJSON(
            $this->getAction()->onUpdate($request->getParsedBody())
        );

        return $data;
    }

    /**
     * Authenticate Contact
     *
     * @param RequestInterface  $request  Request.
     *
     * @param ResponseInterface $response Response.
     *
     * @param array             $args     Arguments.
     *
     * @return boolean
     */
    public function onDelete(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    ) {
        $data = $response->withJSON(
            $this->getAction()->onDelete($args)
        );

        return $data;
    }
}
