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
 * @link      https://github.com/benshez/geo-services
 */

namespace Agora\Bundles\Locations\Actions;

use Agora\Modules\Config\Config;
use Agora\Bundles\Locations\Actions\Action;
use Agora\Bundles\Locations\Validation\Validation;

class Get extends Action
{
    const REFERENCE = 'locations';
    const REFERENCE_OBJECT = 'name';
    const KEY = 'description';
    
    /**
     * Get Locations
     *
     * @param array $args Locations.
     *
     * @return Locations
     */
    public function onGet(array $args)
    {
        if (isset($role[self::KEY])) {
            $validator = new Validation($this);
             
            if (!$this->formIsValid(
                $this->getValidator($validator),
                self::REFERENCE,
                'get',
                array(
                    self::KEY => $args[self::KEY],
                    'entity' => 'location'
                )
            )) {
                $messages = $this->getValidator($validator)->getMessagesAray();
                return $messages;
            }
        }
        
        $finder = $this->getEntityManager()->getRepository(
            $this->getReference(self::REFERENCE)
        );
        
        $range = $this->getOffsetAndLimit(0, $args['offset']);
        
        $locations = $finder->findBy(
            isset($args['industry']) ?
            array('industry' => $args['industry']) :
            array(),
            array('locations.createdAt'),
            $range['limit'],
            $range['offset']
        );
        
        return ($locations);
    }
}
