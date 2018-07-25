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

namespace AgoraApi\Application\Services;

use AgoraApi\Application\Controllers\ContactController;

class AuthenticationService
{
    protected $_controller;

    public function __construct(
        ContactController $controller
    ) {
        $this->_controller = $controller;
    }

    /**
     * This method creates the Zend\Authentication\AuthenticationService service
     * and returns its instance.
     */
    public function __invoke(
        array $options = null
    ) {
        return $this->_controller->login($options);
    }
}
