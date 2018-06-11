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

namespace Agora\Modules\Middleware\TokenAuthentication;

use Agora\Bundles\Contact\Actions\Get as Contact;
use Agora\Bundles\Roles\Actions\Get as Roles;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Permissions\Acl\Acl as ZendAcl;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\Permissions\Acl\Role\GenericRole as Role;

class TokenAuthentication extends ZendAcl
{
    protected $container;
    protected $apiVersion;
    protected $roles;
    protected $route;
    protected $routeIndex;
    protected $defaultRole = 'Guest';

    public function __construct(ContainerInterface $container, array $route, int $routeIndex)
    {
        $this->container = $container;
        $this->apiVersion = $container['settings']['version'];
        $this->route = $route;
        $this->routeIndex = $routeIndex;
    }

    public function __invoke(
        RequestInterface $request,
        ResponseInterface $response,
        $next
    ) {
        $this->createAccesslist();

        $routeInfo = $request->getAttribute('routeInfo');

        $router = $this->container->get('router');

        if (null === $routeInfo || ($routeInfo['request'] !== [$request->getMethod(), (string) $request->getUri()])) {
            $request = $this->dispatchRouterAndPrepareRoute($request, $router);
            $routeInfo = $request->getAttribute('routeInfo');
        }

        $route = $request->getAttribute('route')->getPattern();
        $method = $request->getMethod();

        $token = (isset($request->getHeader('authorization')[0])) ? $request->getHeader('authorization')[0] : null;
        $user = null;
        $role = $this->defaultRole;

        if (null !== $token) {
            $user = new Contact($this->container);
            $role = $user->onGetActiveUserRoleByToken($token);
            $role = ($role) ? $role : $this->defaultRole;
        }

        if (!$this->isAllowed($role, $route, $method)) {
            return $this->denyAccess();
        }

        $isCleanIP = $this->isCleanIP($_SERVER['REMOTE_ADDR']);

        if (!$isCleanIP) {
            $this->denyAccess();
        }

        $response = $next($request, $response);

        return $response;
    }

    private function setRoles()
    {
        $roles = new Roles($this->container);
        $this->roles = $roles->onGet(
            [
                'id' => null,
                'offset' => 10,
                'sender' => 'self',
            ]
        );
    }

    private function createAccesslist()
    {
        $this->setRoles();

        $allowedResource = $this->route['pattern'][$this->routeIndex];
        $allowedMethod = $this->route['methods'][$this->routeIndex];
        $allowedRoles = $this->route['roles'][$this->routeIndex];
        $resourceAdded = false;

        foreach ($this->roles as $role) {
            $this->addRole(new Role($role->getRole()));

            if (!$resourceAdded) {
                $this->addResource(new Resource($allowedResource));
                $resourceAdded = true;
            }

            if (in_array($role->getRole(), $allowedRoles, true)) {
                $this->allow($role->getRole(), $allowedResource, $allowedMethod);
            }
        }
    }

    private function denyAccess()
    {
        http_response_code(401);
        exit;
    }

    private function isCleanIP($ip)
    {
        $whiteList = ['127.0.0.1', '192.168.1.7'];

        return in_array($ip, $whiteList, true);
    }
}
