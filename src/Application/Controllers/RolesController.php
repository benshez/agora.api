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

use AgoraApi\Application\Core\Adapters\MailGunAdapter;
use AgoraApi\Application\Core\Interfaces\IController;
use AgoraApi\Application\Core\Validation\Validator;
use AgoraApi\Application\Repositories\RolesRepository;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use AgoraApi\Infrastructure\Handlers\ApiErrorHandler;
use Doctrine\ORM\EntityManager;
use JMS\Serializer\SerializerBuilder;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RolesController implements IController
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
     * @var AgoraApi\Application\Entities\RolesRepository
     */
    protected $_rolesRepository;
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
        RolesRepository $rolesRepository,
        Validator $validator,
        AgoraApiConfiguration $parameters,
        MailGunAdapter $mailer
    ) {
        $this->_errorHandler = $errorHandler;
        $this->_entityManager = $entityManager;
        $this->_rolesRepository = $rolesRepository;
        $this->_validator = $validator;
        $this->_parameters = $parameters;

        $mailer->sendHtml($to = 'benshez1@gmail.com', $from = 'sandbox6ba7f0d99fb64af597710ae5a14206b7.mailgun.org', $subject = 'hello', $html = 'world');
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
                $scope = new \AgoraApi\Domain\Token();
                $scope->decoded = $this->_request->getAttribute('token');

                if (!$scope->hasScope(['roles.get'])) {
                    return new \AgoraApi\Application\Response\UnauthorizedResponse('Error Processing Request', 401);
                }

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
