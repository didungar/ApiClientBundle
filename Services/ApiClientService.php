<?php
namespace DidUngar\ApiClientBundle\Services;

class ApiClientService {
	protected $api_url;
	public function __construct(string $api_url) {
		$this->api_url = $api_url;
	}
	protected $auth_user = null;
	protected $auth_pw = null;
	public function setAuth(string $auth_user, string $auth_pw) {
		$this->auth_user = $auth_user;
		$this->auth_pw = $auth_pw;
		return $this;
	}
	protected $api_client = null;
	protected $secret = null;
	public function setAuthClientSecret(string $api_client, string $secret) {
		$this->api_client = $api_client;
		$this->secret = $secret;
		return $this;
	}
	public function query($sUri, $aData=[]) {
		if ( preg_match('/^http/', $sUri) ) {
			$sUrl = $sUri;
		} else {
			$sUrl = $this->api_url.$sUri;
		}

		$aData['client'] = 'ApiClientService';
		if ( $this->api_client ) {
			$aData['client'] = $this->api_client;
		}
		if ( $this->secret ) {
			$aData['secret'] = md5(date('Ymd').$this->secret);
		}

		$postdata = http_build_query(
			$aData
		);

		$opts = ['http' =>
					 [
						 'method'  => 'POST',
						 'header'  => ['Content-type: application/x-www-form-urlencoded'],
						 'content' => $postdata,
					 ],
		];
		if ( $this->auth_user && $this->auth_pw ) {
			$opts['http']['header'][] =
				"Authorization: Basic "
				.base64_encode("{$this->auth_user}:{$this->auth_pw}")
			;
		}

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



