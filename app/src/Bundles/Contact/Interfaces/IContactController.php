<?php

namespace Agora\Bundles\Contact\Interfaces;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Agora\Modules\Base\Interfaces\IBaseController;

interface IContactController extends IBaseController
{
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
    public function authenticateOne(
        RequestInterface $request,
        ResponseInterface $response,
        array $args
    );
}
