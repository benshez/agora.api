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

namespace Agora\Bundles\Pages\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Pages\Actions\Action;
use Agora\Bundles\Pages\Validation\Validation;

class Delete extends Action
{
    const REFERENCE = 'pages';
    const REFERENCE_OBJECT = 'name';
    const KEY = 'id';

    /**
     * Delete Pages
     *
     * @param array $args Pages.
     *
     * @return Pages
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
        
        $page = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            array(self::KEY => $args)
        );
  
        if (!$page) {
            return false;
        }

        if (!$page->getEnabled()) {
            $this->onBaseActionDelete()->delete($page);
        } else {
            $this->onBaseActionSave()->disable($page);
        }
        
        return false;
    }
}
