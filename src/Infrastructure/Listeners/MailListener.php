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

namespace AgoraApi\Infrastructure\Listeners;

use AgoraApi\Application\Core\Interfaces\IEventSubscriberInterface;
use AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration;
use AgoraApi\Infrastructure\Handlers\ApiErrorHandler;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class MailListener implements IEventSubscriberInterface
{
    public const ON_SEND_ACTIVATION = 'OnSendActivationInfo';
    public const ON_SEND_DEACTIVATION = 'OnSendDeactivationInfo';


    /**
     * @var AgoraApi\Infrastructure\Handlers\ApiErrorHandler
     */
    protected $_errorHandler;
    /**
     * @var AgoraApi\Infrastructure\Configuration\AgoraApiConfiguration
     */
    protected $_parameters;
    /**
     * @var \PHPMailer
     */
    protected $_mailer;

    /**
     * Initialise BaseAction To Set Container.
     *
     * @param ContainerInterface $container containerInterface
     */
    public function __construct(
        ApiErrorHandler $errorHandler,
        AgoraApiConfiguration $parameters,
        \PHPMailer $mailer
    ) {
        $this->_errorHandler = $errorHandler;
        $this->_parameters = $parameters;
        $this->_mailer = $mailer;
    }

    public function getSubscribedEvents()
    {
        return [
            self::ON_SEND_ACTIVATION,
            self::ON_SEND_DEACTIVATION,
        ];
    }

    public function OnSendActivationInfo(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof \Agora\Bundles\Contact\Entity\Contact) {
            $data = [
                'email' => $entity->getEmail(),
                'text' => 'Please verify email to submit enquiry!',
            ];
            //$this->_mailer->sendHtml
            // $this->_mailer->send('User/Registration.twig', ['data' => $data], function ($message) use ($data) {
            //     $message->to($data['email']);
            //     $message->from('benshez1@gmail.com');
            //     $message->fromName('Ben van Heerden');
            //     $message->subject('Please verify email to submit enquiry!');
            // });
        }
    }

    public function OnSendDeactivationInfo(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
    }
}
