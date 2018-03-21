<?php

namespace Agora\Modules\Lookup\ABN;

class AbnLookup extends \SoapClient
{
    private $guid = '';
    
    public function __construct($settings)
    {
        $this->guid = $settings['abr']['guid'];

        $params = array(
            'soap_version' => SOAP_1_1,
            'exceptions' => true,
            'trace' => 1,
            'cache_wsdl' => WSDL_CACHE_NONE
        );

        parent::__construct($settings['abr']['url'], $params);
    }

    public function searchByAbn($abn, $historical = 'N')
    {
        $params = new \stdClass();
        $params->searchString = $abn;
        $params->includeHistoricalDetails = $historical;
		$params->authenticationGuid = $this->guid;
		
        return $this->SearchByABNv201408($params);
	}
	
	public function searchByAsic($acn, $historical = 'N')
    {
        $params = new \stdClass();
        $params->searchString = $acn;
        $params->includeHistoricalDetails = $historical;
		$params->authenticationGuid = $this->guid;
		
        return $this->SearchByASICv201408($params);
    }
}
