<?php
/**
 * Delete File Doc Comment
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

namespace Agora\Bundles\Industries\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Industries\Actions\Action;
use Agora\Bundles\Industries\Validation\Validation;

class Delete extends Action
{
    const REFERENCE = 'industries';
    const REFERENCE_OBJECT = 'name';
    const KEY = 'id';

    /**
     * Delete Industries
     *
     * @param array $args Industry.
     *
     * @return Industry
     */
    public function onDelete(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'delete',
            $args
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();
            return $messages;
        }
        
        $industry = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            array(
                self::KEY => $args
                )
        );
  
        if (!$industry) {
            return false;
        }

        if (!$industry->getEnabled()) {
            $this->onBaseActionDelete()->delete($industry);
        } else {
            $this->onBaseActionSave()->disable($industry);
        }
        
        return false;
    }
}
