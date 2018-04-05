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
use Agora\Modules\Base\Actions\BaseHydrate;
use Agora\Bundles\Industries\Actions\Action;
use Agora\Bundles\Industries\Entity\Industries;
use Agora\Bundles\Industries\Validation\Validation;

class Add extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'industries';
    const KEY = 'id';
    
    /**
     * Add Industry
     *
     * @param array $args Industry.
     *
     * @return Industry
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

        $industry = new Industries();
        
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
    
    /**
     * Add Industry By ABN Or ABR Lookup
     *
     * @param string $abn      ABR Lookup Entity Code.
     *
     * @param array  $business ABR Lookup Entity Code.
     *
     * @return Industry
     */
    public function onAddByABRLookup(string $abn, array $business)
    {
        $industry = false;

        if ($abn != '') {
            $industry = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                array(
                    self::KEY => $abn
                    )
            );

            if ($industry && $industry->getId()) {
                return $industry;
            }
        }
        
        if (!$industry) {
            $industry = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                array(
                    self::KEY => $business->entityType->entityTypeCode
                    )
            );
        
            if ($industry && $industry->getId()) {
                return $industry;
            }
            
            $industryArgs = array(
                'enabled' => 1,
                'type' => $business->entityType->entityTypeCode,
                'description' => $business->entityType->entityDescription,
            );
            
            $industry = $this->onAdd($industryArgs);

            return $industry;
        }
        
        return false;
    }
}
