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

namespace Agora\Modules\Mailer\User;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class SendWelcomeEmail
{
    public function postPersist(LifecycleEventArgs $event)
    {
        // $entity = $args->getEntity(); $em = $args->getEntityManager()

        // $mailer = $this->getContainer()->get('mailer');

        // $data = ['email' => $contact->getEmail(), 'text' => 'Please verify email to submit enquiry!'];

        // $mailer->send('Master.twig', ['data' => $data], function ($message) use ($data) {
        //     $message->to($data['email']);
        //     $message->from('benshez1@gmail.com');
        //     $message->fromName('Ben van Heerden');
        //     $message->subject('Please verify email to submit enquiry!');
        // });
    }
}
