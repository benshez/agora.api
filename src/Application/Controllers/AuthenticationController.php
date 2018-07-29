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

namespace AgoraApi\Application\Controllers;

use AgoraApi\Application\Core\Interfaces\IController;
use AgoraApi\Application\Core\Validation\Validator;
use AgoraApi\Application\Helpers\AgoraApiArrayHelper;
use AgoraApi\Application\Repositories\ContactRepository;
use AgoraApi\Application\Repositories\RoleRoutesRepository;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use AgoraApi\Infrastructure\Handlers\ApiErrorHandler;
use Doctrine\ORM\EntityManager;
use Firebase\JWT\JWT;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Tuupola\Base62;
use Zend\Crypt\Password\Bcrypt;

class AuthenticationController implements IController
{
    /**
     * @var AgoraApi\Infrastructure\Handlers\ApiErrorHandler
     */
    protected $_errorHandler;
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_entityManager;
    /**
     * @var AgoraApi\Application\Entities\ContactRepository
     */
    protected $_contactRepository;
    /**
     * @var AgoraApi\Application\Entities\RolesRoleRoutesRepository
     */
    protected $_roleRoutesRepository;
    /**
     * @var AgoraApi\Application\Core\Validation\Validator
     */
    protected $_validator;
    /**
     * @var AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration
     */
    protected $_parameters;
    /**
     * @var Psr\Http\Message\RequestInterface
     */
    protected $_request;
    /**
     * @var Psr\Http\Message\ResponseInterface
     */
    protected $_response;

    protected $_requestedRoutes;
    protected $_passedParameters;
    protected $_user;
    protected $_isValidUser = true;

    public function __construct(
        ApiErrorHandler $errorHandler,
        EntityManager $entityManager,
        ContactRepository $contactRepository,
        RoleRoutesRepository $roleRoutesRepository,
        Validator $validator,
        AgoraApiConfiguration $parameters
    ) {
        $this->_errorHandler = $errorHandler;
        $this->_entityManager = $entityManager;
        $this->_contactRepository = $contactRepository;
        $this->_roleRoutesRepository = $roleRoutesRepository;
        $this->_validator = $validator;
        $this->_parameters = $parameters;
    }

    public function authenticate(
        Request $request,
        Response $response,
        $arguments = null
    ) {
        $this->_request = $request;
        $this->_response = $response;
        $this->_requestedRoutes = $request->getParsedBody() ?: [];
        $this->_passedParameters = ['user' => null, 'password' => null];
        $this->_user = null;

        $this->OnGetParameters();

        $this->_user = $this
        ->_contactRepository
        ->findOneByEmail($this->_passedParameters['user']);

        $cc = $this
        ->_contactRepository->findById($this->_user[0]['id']);

        $this->OnValidate();

        if (!$this->_isValidUser) {
            return $this->_errorHandler->OnCreateValidationResponse(
                $request,
                $response,
                ['Invalid user name or password.']
            );
        }

        $this->OnGenerateToken();

        return $this->OnSerialize();
    }

    public function OnSerialize()
    {
        try {
            $serializer = SerializerBuilder::create()->build();
            return $this->_response->withJSON($serializer->serialize($this->_data, 'json'));
        } catch (\Exception $e) {
            $this->_errorHandler->OnCreateExceptionsResponse(
                $this->_request,
                $this->_response,
                $e
            );
        }
    }

    public function OnValidate(): void
    {
        $this->_isValidUser = true;
        $passedPassword = $this->_passedParameters['password'];

        $bcrypt = new Bcrypt();
        $encrypt = $bcrypt->create($passedPassword);

        $passwordHash = $this->_user[0]['password'];
        $this->_isValidUser = $bcrypt->verify($passedPassword, $passwordHash);
    }

    private function OnGetParameters(): void
    {
        $this->_passedParameters = ['user' => null, 'password' => null];

        if (preg_match("/Basic\s+(.*)$/i", $this->_request->getHeaderLine('Authorization'), $matches)) {
            $explodedCredential = explode(':', base64_decode($matches[1]), 2);

            if (count($explodedCredential) == 2) {
                list($this->_passedParameters['user'], $this->_passedParameters['password']) = $explodedCredential;
            }
        }
    }

    private function OnGenerateToken(): void
    {
        $helper = new AgoraApiArrayHelper();
        $validRoutes = $helper->array_pluck($this->_user, 'route');

        $scopes = array_filter($this->_requestedRoutes, function ($needle) use ($validRoutes) {
            return in_array($needle, $validRoutes);
        });

        $now = new \DateTime();
        $future = new \DateTime($this->_parameters->getSetting('tokenTimeot'));
        $server = $this->_request->getServerParams();

        $jti = (new Base62())->encode(random_bytes(16));

        $payload = [
            'iat' => $now->getTimeStamp(),
            'exp' => $future->getTimeStamp(),
            'jti' => $jti,
            'sub' => $server['PHP_AUTH_USER'],
            'scope' => $scopes,
        ];

        $secret = getenv('JWT_SECRET');
        $token = JWT::encode($payload, $secret, 'HS256');

        $this->_data['token'] = $token;
        $this->_data['expires'] = $future->getTimeStamp();
    }
}
