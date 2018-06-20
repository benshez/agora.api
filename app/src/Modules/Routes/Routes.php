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

namespace Agora\Modules\Routes;

use Agora\Modules\Middleware\TokenAuthentication\TokenAuthentication as TokenAuthentication;
use Interop\Container\ContainerInterface;

class Routes
{
    const PATTERN = 'pattern';
    const ACTION = 'actions';
    const MIDDLEWARE = 'middleware';

    private $_app;
    private $_routes;

    /**
     * Ctor
     *
     * @param \Slim\App $app    App.
     *
     * @param array     $routes App Routes.
     */
    public function __construct(\Slim\App $app, array $routes)
    {
        $this->_routes = $routes;
        $this->_app = $app;
        $this->_addRoutes();
    }

    /**
     * Create Routes
     */
    private function _addRoutes()
    {
        $device = array();
        //$index = 0;
        //print_r($this->_routes['routes']);
        foreach ($this->_routes['routes'] as $route) {
            //$device[(string)$index] = (string)$method;
            
            foreach ($route['methods'] as $index => $method) {
                //$device[(string)$index] = (string)$method;
                
                switch ($method) {
                    case 'GET':
                        $this->_addGetRoutes($route, $index);

                        break;
                    case 'POST':
                        $this->_addPostRoutes($route, $index);

                        break;
                    case 'PUT':
                        $this->_addPutRoutes($route, $index);

                        break;
                    case 'DELETE':
                        $this->_addDeleteRoutes($route, $index);

                        break;
                }
            }
        }
        //print_r($devices);
    }

    /**
     * Create Get Routes
     *
     * @param array   $route App Route.
     *
     * @param int $index App Route.
     */
    private function _addGetRoutes(array $route, int $index)
    {
        if ($route[self::MIDDLEWARE][$index]) {
            $container = $this->_app->getContainer();
            $middleware = $this->_addMiddleware($container, $route, $index);

            $this->_app->get(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            )
            ->add(
                function (
                    $request,
                    $response,
                    $next
                ) use (
                    $container,
                    $middleware
                ) {
                    return $middleware(
                        $request,
                        $response,
                        $next
                    );
                }
            );
        } else {
            $this->_app->get(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            );
        }
    }

    /**
     * Create Post Routes
     *
     * @param array   $route App Route.
     *
     * @param int $index App Route.
     */
    private function _addPostRoutes(array $route, int $index)
    {
        if ($route[self::MIDDLEWARE][$index]) {
            $container = $this->_app->getContainer();
            $middleware = $this->_addMiddleware($container, $route, $index);

            $this->_app->post(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            )
            ->add(
                function (
                    $request,
                    $response,
                    $next
                ) use (
                    $container,
                    $middleware
                ) {
                    return $middleware(
                        $request,
                        $response,
                        $next
                    );
                }
            );
        } else {
            $this->_app->post(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            );
        }
    }

    /**
     * Create Put Routes
     *
     * @param array   $route App Route.
     *
     * @param int $index App Route.
     */
    private function _addPutRoutes(array $route, int $index)
    {
        if ($route[self::MIDDLEWARE][$index]) {
            $container = $this->_app->getContainer();
            $middleware = $this->_addMiddleware($container, $route, $index);

            $this->_app->put(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            )
            ->add(
                function (
                    $request,
                    $response,
                    $next
                ) use (
                    $container,
                    $middleware
                ) {
                    return $middleware(
                        $request,
                        $response,
                        $next
                    );
                }
            );
        } else {
            $this->_app->put(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            );
        }
    }

    /**
     * Create Delete Routes
     *
     * @param array   $route App Route.
     *
     * @param int $index App Route.
     */
    private function _addDeleteRoutes(array $route, int $index)
    {
        if ($route[self::MIDDLEWARE][$index]) {
            $container = $this->_app->getContainer();
            $middleware = $this->_addMiddleware($container, $route, $index);

            $this->_app->delete(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            )->add(
                function (
                    $request,
                    $response,
                    $next
                ) use (
                    $container,
                    $middleware
                ) {
                    return $middleware(
                        $request,
                        $response,
                        $next
                    );
                }
            );
        } else {
            $this->_app->delete(
                $route[self::PATTERN][$index],
                $route[self::ACTION][$index]
            );
        }
    }

    /**
     * Create Middleware
     *
     * @param ContainerInterface $container App Container.
     *
     * @param array              $route     App Route.
     *
     * @param int            $index     App Route.
     *
     * @return middleware
     */
    private function _addMiddleware(ContainerInterface $container, array $route, int $index)
    {
        $middleware = '';

        switch ($route[self::MIDDLEWARE][$index]) {
            case 'TokenAuthentication':
                $middleware = [new TokenAuthentication($container, $route, $index), '__invoke'];

                break;
        }

        return $middleware;
    }
}
