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
use AgoraApi\Application\Repositories\ContactRepository;
use AgoraApi\Application\Response\UnauthorizedResponse;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use AgoraApi\Infrastructure\Handlers\ApiErrorHandler;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;

class ContactController implements IController
{
    /**
     * @var Psr\Http\Message\RequestInterface
     */
    protected $_request;
    /**
     * @var Psr\Http\Message\ResponseInterface
     */
    protected $_response;
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $_entityManager;
    /**
     * @var AgoraApi\Application\Core\Validation\Validator
     */
    protected $_validator;
    /**
     * @var AgoraApi\Infrastructure\Handlers\ApiErrorHandler
     */
    protected $_errorHandler;
    /**
     * @var AgoraApi\Application\Entities\ContactRepository
     */
    protected $_contactRepository;
    /**
     * @var AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration
     */
    protected $_parameters;
    /**
     * @var bool
     */
    protected $_validatorsIsValid = true;
    /**
     * @var string
     */
    protected $_validatorsMessage = null;
    /**
     * @var array
     */
    protected $_validatorArray = [];
    /**
     * @var any
     */
    protected $_data = null;

    protected const fileKey = 'rolesId';
    protected const fileOffset = 'rolesOffset';
    protected const fileLimit = 'rolesLimit';

    public function __construct(
        ApiErrorHandler $errorHandler,
        EntityManager $entityManager,
        ContactRepository $contactRepository,
        Validator $validator,
        AgoraApiConfiguration $parameters
    ) {
        $this->_errorHandler = $errorHandler;
        $this->_entityManager = $entityManager;
        $this->_contactRepository = $contactRepository;
        $this->_validator = $validator;
        $this->_parameters = $parameters;
    }

    public function get(
        Request $request,
        Response $response,
        $offset = null,
        $limit = null,
        $id = null
    ) {
        $this->_request = $request;
        $this->_response = $response;
        $this->_validatorArray = [];
        $this->_data = null;

        try {
            if (null === $offset) {
                $this->getById($id);
            }

            if (null === $id) {
                $this->getPaginated($offset, $limit);
            }

            if (!$this->_validatorsIsValid) {
                return $this->_validatorsMessage;
            }

            return $this->OnSerialize();
        } catch (\Exception $e) {
            return $this->_errorHandler->OnCreateExceptionsResponse(
                $this->_request,
                $this->_response,
                $e
            );
        } catch (\Throwable $throwable) {
            return $this->_errorHandler->OnCreateExceptionsResponse(
                $this->_request,
                $this->_response,
                $throwable
            );
        }
    }

    public function login($arguments)
    {
        $this->_data = null;
        $this->_data = $this->_contactRepository
                ->findOneByEmail($arguments['user']);

        //return $this->OnSerialize();

        // If there is no such user, return 'Identity Not Found' status.
        //if ($user == null) {
        //throw new \Exception('Error Processing Request', 1);
        return new UnauthorizedResponse('Error Processing Request', 501);
        return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']
            );
        // }

        // If the user with such email exists, we need to check if it is active or retired.
        // Do not allow retired users to log in.
        // if ($user->getStatus() == User::STATUS_RETIRED) {
        //     return new Result(
        //         Result::FAILURE,
        //         null,
        //         ['User is retired.']
        //     );
        // }

        // Now we need to calculate hash based on user-entered password and compare
        // it with the password hash stored in database.
        $bcrypt = new Bcrypt();
        $passwordHash = $user->getPassword();

        if ($bcrypt->verify($this->password, $passwordHash)) {
            // Great! The password hash matches. Return user identity (email) to be
            // saved in session for later use.
            return new Result(
                    Result::SUCCESS,
                    $this->email,
                    ['Authenticated successfully.']
            );
        }

        // If password check didn't pass return 'Invalid Credential' failure status.
        return new Result(
                Result::FAILURE_CREDENTIAL_INVALID,
                null,
                ['Invalid credentials.']
        );
        // $authAdapter = $this->_authAdaptor;
        // $authAdapter->setEmail($arguments['user']);
        // $authAdapter->setPassword($arguments['password']);
        // $result = $this->_authAdaptor->authenticate();
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
        $this->_validatorsIsValid = true;
        $this->_validatorsMessage = '';

        $this->_validator->validate(
            $this->_validatorArray['validatorData'],
            $this->_validatorArray['validatorRules']
        );

        if ($this->_validator->fails()) {
            $this->_validatorsIsValid = false;
            $this->_validatorsMessage = $this->_errorHandler->OnCreateValidationResponse(
                $this->_request,
                $this->_response,
                $this->_validator->getErrors()
            );
        }
    }

    private function getById($id): void
    {
        $this->_validatorArray = $this->_validator->getIdValidator($id);

        $this->OnValidate();

        if ($this->_validatorsIsValid) {
            $this->_data = $this->_rolesRepository->findById((int) $id);
        }
    }

    private function getPaginated($offset, $limit): void
    {
        $this->_validatorArray = $this->_validator->getOffsetValidator($offset, $limit);

        $this->OnValidate();

        if ($this->_validatorsIsValid) {
            $this->_data = $this->_rolesRepository->findPaginated((int) $offset, (int) $limit);
        }
    }
}
