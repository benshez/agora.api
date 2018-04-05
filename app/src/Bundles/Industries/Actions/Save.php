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

namespace Agora\Bundles\Industries\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Industries\Actions\Action;
use Agora\Modules\Base\Actions\BaseHydrate;
use Agora\Bundles\Industries\Validation\Validation;

class Save extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'entities';
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

        $industry = $this->onBaseActionGet()->get(
            $this->getReference(self::REFERENCE),
            array(
                self::KEY => $args[self::KEY]
            )
        );
        
        $hydrate = new BaseHydrate($this->getContainer());
        
        $industry = $this->onBaseActionSave()->save(
            $hydrate->hydrate($industry, $args)
        );

        if (!$industry) {
            return false;
        }

        if ($industry->getId()) {
            $industry = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                array(
                    self::KEY => $industry->getId()
                    )
            );
            return $industry;
        }

        return false;
    }
}
