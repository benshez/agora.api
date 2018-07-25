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

use AgoraApi\Application\Services\MailService;
use AgoraApi\Core\Adapters\MailGunAdapter;
use Mailgun\Mailgun;
use Psr\Container\ContainerInterface;

return [
    Mailgun::class => function (ContainerInterface $container) {
        return Mailgun::create($_ENV['MAILGUN']);
    },
    MailGunAdapter::class => function (ContainerInterface $container) {
        $config = $container->get(AgoraApiParameters::class);

        return new MailGunAdapter($config->getSetting('mail.mailgunDomain'), $container->get(Mailgun::class));
    },
    MailService::class => function (ContainerInterface $container) {
        return $container->get(MailGunAdapter::class);
    },
];
