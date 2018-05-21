<?php
/**
 * BaseGet File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  BaseSave
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Roles\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Roles\Actions\Action;
use Agora\Bundles\Roles\Validation\Validation;

class Get extends Action
{
    const REFERENCE = 'roles';
    const REFERENCE_OBJECT = 'name';
    const KEY = 'id';
    
    /**
     * Get Roles
     *
     * @param array $args Role.
     *
     * @return Role
     */
    public function onGet(array $args)
    {
        if (isset($args[self::KEY])) {
            $validator = new Validation($this);
            
            if (!$this->formIsValid(
                $this->getValidator($validator),
                self::REFERENCE,
                'get',
                array(
                    self::KEY => $args[self::KEY],
                    'entity' => 'role'
                )
            )) {
                $messages = $this->getValidator($validator)->getMessagesAray();
                return $messages;
            }
        }
  
        $finder = new \Agora\Modules\Base\Entity\BaseEntity(
            $this->getEntityManager(),
            $this->getEntityManager()->getClassMetadata(
                $this->getReference(self::REFERENCE)
            )
        );
        
        $range = $this->getOffsetAndLimit(0, $args['offset']);
        
        $roles = $finder->findBy(
            isset($args[self::KEY]) ?
            array(self::KEY => $args[self::KEY]) :
            array(),
            null,
            $range['limit'],
            $range['offset']
        );

        if(!isset($args['sender'])) {
                    // $mailer = $this->getContainer()->get('mailer');

                    // $user = ['email' => 'benshez1@gmail.com', 'text' => 'Please verify email to submit enquiry!'];

                    // $mailer->send('Master.twig',['user' => $user], function($message) use ($user){
                    //     $message->to($user['email']);
                    //     $message->from('benshez1@gmail.com');
                    //     $message->fromName('Ben van Heerden');
                    //     $message->subject('Please verify email to submit enquiry!');
                    // });
        
            // $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
            // $roles = $serializer->serialize($roles, 'json');
            return $this->onSerialize($roles);
        }

        return ($roles);
    }
}
