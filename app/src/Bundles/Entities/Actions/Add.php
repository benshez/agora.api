<?php
/**
 * This file is part of the Agora API.
 *
 * PHP Version 7.1.9
 *
 * @category  Agora
 * @package   Agora
 * @author    Ben van Heerden <benshez1@gmail.com>
 * @copyright 2017-2018 Agora
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link      https://github.com/benshez/agora.api
 */

namespace Agora\Bundles\Entities\Actions;

use Agora\Bundles\Entities\Entity\Entities;
use Agora\Bundles\Entities\Validation\Validation;
use Agora\Modules\Base\Actions\BaseHydrate;
use Agora\Modules\Config\Config;

class Add extends Action
{
    const REFERENCE_OBJECT = 'name';
    const REFERENCE = 'entities';
    const KEY = 'id';

    /**
     * Save Entity
     *
     * @param array $args Entity.
     *
     * @return Entity
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

        $entity = new Entities();

        $hydrate = new BaseHydrate($this->getContainer());

        $entity = $this->onBaseActionSave()->save(
            $hydrate->hydrate($entity, $args)
        );

        if (!$entity) {
            return false;
        }

        if ($entity->getId()) {
            $entity = $this->onBaseActionGet()->get(
                $this->getReference(self::REFERENCE),
                [self::KEY => $entity->getId()]
            );

            return $entity;
        }

        return false;
    }

    /**
     * Add Entity By ABR Lookup
     *
     * @param string $abn ABR Lookup Entity Code.
     *
     * @return Entity
     */
    public function onAddByABRLookup(string $abn)
    {
        $entity = false;

        $entity = $this->onBaseActionGet()->get(
            $this->getReference('entities'),
            ['identifier' => (int) str_replace(' ', '', $abn)]
        );

        if ($entity && $entity->getId()) {
            return $entity;
        }

        if (!$entity) {
            $abnlookup = new \Agora\Modules\Lookup\ABN\AbnLookup($this->getSettings());
            $business = $abnlookup->searchByAbn($abn);
            $business = $business->ABRPayloadSearchResults
            ->response->businessEntity201408;

            $config = new Config($this->getSettings());

            $days = $this->getSettings()['trial_period'];

            if (isset($business->legalName) || isset($business->mainName)) {
                $entitiesName = isset($business->legalName) ?
                $business->legalName->givenName . ', ' . $business->legalName->familyName :
                $business->mainName->organisationName;

                $state = 'N/A';
                $poCode = 'N/A';

                if (isset($this->business->mainBusinessPhysicalAddress)) {
                    $state = $this->business->mainBusinessPhysicalAddress->stateCode;
                    $poCode = $this->business->mainBusinessPhysicalAddress->postcode;
                }

                $industry = false;

                if ($business->entityType->entityTypeCode) {
                    $industry = new \Agora\Bundles\Industries\Actions\Add(
                        $this->getContainer()
                    );

                    if ('' !== $abn) {
                        $industry = $industry->onAddByABRLookup(
                            $abn,
                            $business
                        );
                    } else {
                        $industry = $industry->onAddByABRLookup(
                            '',
                            $business
                        );
                    }
                }

                $entityArgs = [
                    'identifier' => $business->ABN->identifierValue,
                    'enabled' => 1,
                    'name' => $entitiesName,
                    'status' => $business->entityStatus->entityStatusCode,
                    'state' => $state,
                    'postCode' => $poCode,
                    'expiresAt' => $config->getDateTimeFuture($days),
                    'industry' => ($industry) ? $industry : null,
                ];

                $entity = $this->onAdd($entityArgs);

                if ($entity) {
                    return $entity;
                }
            }
        }

        return false;
    }
}
