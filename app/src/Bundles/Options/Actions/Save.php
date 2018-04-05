<?php
/**
 * Save File Doc Comment
 *
 * PHP Version 7.0.10
 *
 * @category  Save
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Options\Actions;

use Zend\Crypt\Password\Bcrypt;
use Agora\Modules\Config\Config;
use Agora\Bundles\Options\Actions\Action;
use Agora\Bundles\Options\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;

class Save extends Action
{
    const REFERENCE = 'options';
    
    /**
     * Save Options
     *
     * @param array $args Options.
     *
     * @return Options
     */
    public function onUpdate(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'update',
            $args
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();
            return $messages;
        }
        
        return false;
    }
}
