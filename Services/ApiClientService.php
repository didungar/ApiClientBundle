<?php
namespace DidUngar\ApiClientBundle\Services;

class ApiClientService {
	protected $container;
	public function __construct($service_container) {
		$this->container = $service_container;
	}
	public function query($sUri, $aData=[]) {
		$sUrl = $this->container->getParameter('api_url').$sUri;

		$aData['client'] = 'ApiClientService';
		if ( $this->container->hasParameter('api_client') ) {
			$aData['client'] = $this->container->getParameter('api_client');
		}
		$aData['secret'] = md5(date('Ymd').$this->container->getParameter('secret'));

		$postdata = http_build_query(
		    $aData
		);

		$opts = array('http' =>
		    array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		    )
		);

		$context  = stream_context_create($opts);

		try {
			$result = file_get_contents($sUrl, false, $context);
		} catch (\Exception $e) {
			return null;
		}
		if ( empty($result) ) {
			return null;
		}
		return json_decode($result);
	}
}



