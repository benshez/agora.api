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

namespace AgoraApi\Infrastructure\Handlers;

use Crell\ApiProblem\ApiProblem;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Handlers\AbstractError;
use Throwable;

final class ApiErrorHandler extends AbstractError
{
    protected $_logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->_logger = $logger;
    }

    public function __invoke(Request $request, Response $response, Throwable $throwable)
    {
        return $this->OnCreateExceptionsResponse($request, $response, $throwable);
    }

    public function OnCreateExceptionsResponse(Request $request, Response $response, Throwable $throwable)
    {
        $this->_logger->critical($throwable->getMessage());

        $status = $throwable->getCode() ?: 500;

        return $this->CreateResponseBody($response, $status, [$throwable->getMessage()], 'exception');
    }

    public function OnCreateValidationResponse(Request $request, Response $response, array $exception)
    {
        return $this->CreateResponseBody($response, 500, $exception, 'validation');
    }

    private function CreateResponseBody(Response $response, int $status, array $message, string $type = 'about:blank')
    {
        $problem = new ApiProblem($message, $type);
        $problem->setStatus($status);
        $body = $problem->asJson(true);

        return $response
                ->withStatus($status)
                ->withHeader('Content-type', 'application/json')
                ->write($body);
    }
}
