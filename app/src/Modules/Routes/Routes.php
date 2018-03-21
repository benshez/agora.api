<?php
/**
 * BaseGet File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  Routes
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Modules\Routes;

use Interop\Container\ContainerInterface;
use Agora\Modules\Middleware\TokenAuthentication\TokenAuthentication as TokenAuthentication;

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
     *
     * @return void
     */
    public function __construct(\Slim\App $app, array $routes)
    {
        $this->_routes = $routes;
        $this->_app = $app;
        $this->_addRoutes();
    }

    /**
     * Create Routes
     *
     * @return void
     */
    private function _addRoutes()
    {
        foreach ($this->_routes as $route) {
            foreach ($route['methods'] as $index => $method) {
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
    }

    /**
     * Create Get Routes
     *
     * @param array   $route App Route.
     *
     * @param integer $index App Route.
     *
     * @return void
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
     * @param integer $index App Route.
     *
     * @return void
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
     * @param integer $index App Route.
     *
     * @return void
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
     * @param integer $index App Route.
     *
     * @return void
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
     * @param integer            $index     App Route.
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
