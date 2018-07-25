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
\Doctrine\DBAL\Types\Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

return [
    'driver' => 'pdo_mysql',
    'user' => $_ENV['DOCTRINE_USERNAME'],
    'password' => $_ENV['DOCTRINE_PASSWORD'],
    'dbname' => $_ENV['DOCTRINE_DATABASE'],
    'host' => $_ENV['DOCTRINE_HOST'],
    'charset' => 'utf8',
    'port' => $_ENV['DOCTRINE_PORT'],
];
