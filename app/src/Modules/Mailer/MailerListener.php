<?php
/**
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

namespace Agora\Modules\Mailer;

use Agora\Modules\Base\Interfaces\IEventSubscriberInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Interop\Container\ContainerInterface;

class MailerListener implements IEventSubscriberInterface
{
    public const ON_SEND_ACTIVATION = 'onSendActivationInfo';
    public const ON_SEND_DEACTIVATION = 'onSendDeactivationInfo';

    private $_container = null;
    
    /**
     * Initialise BaseAction To Set Container
     *
     * @param  ContainerInterface $container ContainerInterface.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->_container = $container;
    }

    public function getSubscribedEvents()
    {
        return [
            self::ON_SEND_ACTIVATION,
            self::ON_SEND_DEACTIVATION,
        ];
    }

    public function onSendActivationInfo(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        $entityManager = $args->getObjectManager();

        if ($entity instanceof \Agora\Bundles\Contact\Entity\Contact) {
            $mailer = $this->_container->get('mailer');

            $data = [
                'email' => $entity->getEmail(),
                'text' => 'Please verify email to submit enquiry!'
            ];
    
            $mailer->send('User/Registration.twig', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email']);
                $message->from('benshez1@gmail.com');
                $message->fromName('Ben van Heerden');
                $message->subject('Please verify email to submit enquiry!');
            });
        }
    }

    public function onSendDeactivationInfo(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
    }
}
