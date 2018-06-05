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

namespace Agora\Bundles\Contact\Events\Listerners;

use Agora\Bundles\Contact\Interfaces\IContactEventListener;

class ContactEventListener implements IContactEventListener
{
    public const ON_SEND_ACTIVATION = 'onSendActivationInfo';
    public const ON_SEND_DEACTIVATION = 'onSendDeactivationInfo';

    private $_container = null;
    
    /**
     * Initialise ContactEventListener To Set Container
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
        $mailer = $this->_container->get('mailer');

        // $data = ['email' => $contact->getEmail(), 'text' => 'Please verify email to submit enquiry!'];

        // $mailer->send('Master.twig', ['data' => $data], function ($message) use ($data) {
        //     $message->to($data['email']);
        //     $message->from('benshez1@gmail.com');
        //     $message->fromName('Ben van Heerden');
        //     $message->subject('Please verify email to submit enquiry!');
        // });
    }

    public function onSendDeactivationInfo(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
    }
}
