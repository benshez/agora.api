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
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use AgoraApi\Infrastructure\Handlers\ApiErrorHandler;
use Doctrine\ORM\EntityManager;

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

    public function login($arguments)
    {
        $this->_data = null;
        $this->_data = $this->_contactRepository
                ->findOneByEmail($arguments['user']);

        return new UnauthorizedResponse('Error Processing Request', 501);
        return new Result(
                Result::FAILURE_IDENTITY_NOT_FOUND,
                null,
                ['Invalid credentials.']
            );
        // }

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
    }

    public function OnSerialize()
    {
    }

    public function OnValidate(): void
    {
    }
}
