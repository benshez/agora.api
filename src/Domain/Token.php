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

namespace AgoraApi\Domain;

final class Token
{
    public $decoded;

    public function populate($decoded): void
    {
        $this->decoded = $decoded;
    }

    public function hasScope(array $scope)
    {
        return (bool) count(array_intersect($scope, $this->decoded['scope']));
    }
}
