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

namespace Agora\Bundles\Pages\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Pages\Actions\Action;
use Agora\Modules\Base\Actions\BaseHydrate;
use Agora\Bundles\Pages\Validation\Validation;

class Save extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'pages';
    const KEY = 'id';
    
    /**
     * Save Role
     *
     * @param array $args Role.
     *
     * @return Role
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

        $page = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            array(self::KEY => $args[self::KEY])
        );
        
        $hydrate = new BaseHydrate($this->getContainer());
        
        $page = $this->onBaseActionSave()->save(
            $hydrate->hydrate($page, $args)
        );

        if (!$page) {
            return false;
        }

        if ($page->getId()) {
            $page = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                array(self::KEY => $page->getId())
            );
            return $page;
        }

        return false;
    }
}
