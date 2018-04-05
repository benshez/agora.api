<?php
/**
 * EmailExistsValidator File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  EmailExistsValidator
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */
namespace Agora\Modules\Validators\Authentication;

use Zend\Validator\AbstractValidator;
use Zend\Crypt\Password\Bcrypt;

class AuthenticationValidator extends AbstractValidator
{

    const USER = 'user';
    const REFERENCE = 'contact';

    protected $messageTemplates = array(
        self::USER  => 'Not a valid user name or password.'
    );

    /**
     * Ctor AuthenticationValidator
     *
     * @param array $options Validator options.
     *
     * @return void
     */
    public function __construct(array $options = array())
    {
        parent::__construct($options);
    }
    
    /**
     * IsValid
     *
     * @param $value Values.
     *
     * @return boolean
     */
    public function isValid($value)
    {
        $isValid = true;
        
        $action = $this->getOption('action');
        
        $contact = $action->onBaseActionGet()->get(
            $action->getReference(self::REFERENCE),
            ['email' => $value['email']]
        );
                
        if ($contact) {
            $bcrypt = new Bcrypt();
            $isValid = $bcrypt->verify($value['password'], $contact->getPassword());
        } else {
            $isValid = false;
        }
        
        if (!$isValid) {
            if ($contact && !$contact->getLocked()) {
                $retries = (null === $contact->getRetries()) ?
                0 :
                $contact->getRetries();
                
                $retries++;
            
                if ($retries > 3) {
                    $contact->setLocked(true);
                } else {
                    $contact->setRetries($retries);
                }

                $contact = $action->onBaseActionSave()->save($contact);
            }
            $this->error(self::USER);
        }

        return $isValid;
    }
}
