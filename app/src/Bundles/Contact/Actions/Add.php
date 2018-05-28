<?php

/**
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category Agora
 *
 *
 * @package  Agora
 *
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 *
 * @link https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Contact\Actions;

use Agora\Bundles\Contact\Entity\Contact;
use Agora\Bundles\Contact\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;
use Zend\Crypt\Password\Bcrypt;

class Add extends Action
{
    const ABN = 'abn';

    const EMAIL = 'email';

    const KEY = 'id';

    const PASSWORD = 'password';

    const REFERENCE = 'contact';

    const REFERENCE_OBJECT = 'name';

    /**
     * Save Contact.
     *
     *
     * @param  array     $args Contact.
     * @return Contact
     */
    public function onAdd(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'add',
            $args
        )
        ) {
            $messages = $this->getValidator($validator)->getMessagesAray();
            $contact = $this->emptyContact();
            $contact['error'] = $messages['error'];
            $contact['message'] = $messages['message'];

            return $contact;
        }

        $contact = new Contact();

        if (isset($args[self::PASSWORD])) {
            $bcrypt = new Bcrypt();
            $password = $bcrypt->create($args[self::PASSWORD]);
            $args[self::PASSWORD] = $password;
        }

        $role = $this->onBaseActionGet()->get(
            $this->getReference('roles'),
            [self::KEY => $args['role']]
        );

        $args['role'] = $role;

        if ($args[self::ABN]) {
            $entity = new \Agora\Bundles\Entities\Actions\Add(
                $this->getContainer()
            );

            $entity = $entity->onAddByABRLookup($args['abn']);

            if ($entity) {
                $args['entity'] = $entity;
            }
        }

        $date = new \DateTime();

        $args['token_expiry'] = $date->modify('+30 days');

        $hydrate = new BaseHydrate($this->getContainer());

        $contact = $hydrate->hydrate($contact, $args);

        $contact = $this->onBaseActionSave()->save($contact);

        if ($contact->getId()) {
            $contact = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                [self::KEY => $contact->getId()]
            );

            $mailer = $this->getContainer()->get('mailer');

            $data = ['email' => $contact->getEmail(), 'text' => 'Please verify email to submit enquiry!'];

            $mailer->send('Master.twig', ['data' => $data], function ($message) use ($data) {
                $message->to($data['email']);
                $message->from('benshez1@gmail.com');
                $message->fromName('Ben van Heerden');
                $message->subject('Please verify email to submit enquiry!');
            });

            return $this->onSerialize($contact);
        }

        return false;
    }
}
