<?php

namespace Agora\Modules\Base\Interfaces;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Agora\Modules\Base\Options\BaseOptions;
use Agora\Modules\Base\Interfaces\IBaseAction;

interface IBaseController
{
    public function __construct(IBaseAction $action);
    public function setAction(IBaseAction $action);
    public function getAction();
    public function fetch(
        RequestInterface $request,
        ResponseInterface $response,
        $sender,
        $args = null,
        BaseOptions $options
    );
    public function fetchOne(
        RequestInterface $request,
        ResponseInterface $response,
        $sender,
        $args,
        BaseOptions $options
    );
    public function fetched(
        RequestInterface $request,
        ResponseInterface $response,
        $args,
        BaseOptions $options
    );
}
