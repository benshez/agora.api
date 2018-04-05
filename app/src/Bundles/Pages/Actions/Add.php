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
use Agora\Bundles\Pages\Entity\Pages;
use Agora\Bundles\Pages\Actions\Action;
use Agora\Modules\Base\Actions\BaseHydrate;
use Agora\Bundles\Pages\Validation\Validation;

class Add extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'pages';
    const KEY = 'id';
    
    /**
     * Add Pages
     *
     * @param array $args Industry.
     *
     * @return Pages
     */
    public function onAdd(array $args)
    {
        $validator = new Validation($this);

        if (!$this->formIsValid(
            $this->getValidator($validator),
            self::REFERENCE,
            'add',
            $args
        )) {
            $messages = $this->getValidator($validator)->getMessagesAray();
            return $messages;
        }

        $page = new Pages();
        
        $hydrate = new BaseHydrate($this->getContainer());
             
        $page = $this->onBaseActionSave()->save(
            $hydrate->hydrate($page, $args)
        );

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
