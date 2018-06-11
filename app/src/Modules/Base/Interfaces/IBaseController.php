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

namespace Agora\Modules\Base\Interfaces;

use Agora\Modules\Base\Options\BaseOptions;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface IBaseController
{
    public function __construct(IBaseAction $action);

    public function setAction(IBaseAction $action);

    public function getAction();

    public function fetch(
        RequestInterface $request,
        ResponseInterface $response,
        $sender,
        $args,
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
