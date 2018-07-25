<?php

/*
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

declare(strict_types=1);


use AgoraApi\Application\Response\UnauthorizedResponse;
use AgoraApi\Application\Services\AuthenticationService;
use AgoraApi\Domain\Token;
use Gofabian\Negotiation\NegotiationMiddleware;
use Micheh\Cache\CacheUtil;
use Psr\Container\ContainerInterface;
use Tuupola\Middleware\CorsMiddleware;
use Tuupola\Middleware\HttpBasicAuthentication;
use Tuupola\Middleware\JwtAuthentication;

return [
    AgoraApiHttpBasicAuthentication::class => function (ContainerInterface $container) {
        $config = $container->get(AgoraApiParameters::class);

        return new HttpBasicAuthentication([
            'path' => '/api/' . $config->getRoutVersion() . '/token',
            'secure' => false,
            'realm' => 'Protected',
            'relaxed' => ['agora.api:8000', '127.0.0.1', 'localhost'],
            'error' => function ($response, $arguments) {
                return new UnauthorizedResponse($arguments['message'], 401);
            },
            'authenticator' => new AuthenticationService($container->get('AgoraApiContactController')),
            // 'users' => [
            //     'test' => 'test',
            // ],
        ]);
    },
    AgoraApiToken::class => function (ContainerInterface $container) {
        return new Token();
    },
    AgoraApiJwtAuthentication::class => function (ContainerInterface $container) {
        $config = $container->get(AgoraApiParameters::class);

        return new JwtAuthentication([
            'path' => '/',
            'ignore' => ['/api/' . $config->getRoutVersion() . '/token', '/info'],
            'secret' => getenv('JWT_SECRET'),
            'logger' => $container->get('AgoraApiErrorLogger'),
            'attribute' => false,
            'secure' => false,
            //'relaxed' => ['agora.api:8000', '127.0.0.1', 'localhost'],
            'error' => function ($response, $arguments) {
                return new UnauthorizedResponse($arguments['message'], 401);
            },
            'before' => function ($request, $response, $arguments) use ($container) {
                $container->get(AgoraApiToken::class)->populate($arguments['decoded']);
            },
        ]);
    },
    AgoraApiCorsMiddleware::class => function (ContainerInterface $container) {
        return new CorsMiddleware([
            'logger' => $container->get('AgoraApiErrorLogger'),
            'origin' => ['http://agora.api:8000'],
            'methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'],
            'headers.allow' => ['Authorization', 'If-Match', 'If-Unmodified-Since'],
            'headers.expose' => ['Authorization', 'Etag'],
            'credentials' => true,
            'cache' => 60,
            'error' => function ($request, $response, $arguments) {
                $data['status'] = 'error';
                $data['message'] = $arguments['message'];
                return $response
                    ->withHeader('Content-Type', 'application/json')
                    ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
            },
        ]);
    },
    AgoraApiNegotiationMiddleware::class => function (ContainerInterface $container) {
        return new NegotiationMiddleware([
            'accept' => ['application/json'],
        ]);
    },
    cache::class => function (ContainerInterface $container) {
        return new CacheUtil();
    },
];
