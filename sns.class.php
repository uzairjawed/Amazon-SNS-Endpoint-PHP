<?php

require 'aws-lib/aws.phar';

class EndpointSNS {

	private $sns;

	public function __construct($key,secret) {

		$this->sns = Aws\Sns\SnsClient::factory(array(
    		'key'    => $key,
    		'secret' => $secret
		));

	}

	/* Generating an endpoint */

	public function generateEndpoint($token,$arn) {
	    try {
			$response = $this->sns->createPlatformEndpoint(array(
    		// PlatformApplicationArn is required
    			'PlatformApplicationArn' => $arn,
    			// Token is required
    			'Token' => $token));
		
			if(isset($response['EndpointArn'])) {

				return $response['EndpointArn'];
			}
			else
				return false;
		}
		catch(Exception $e) {
			
			$message = $e->getMessage();
			preg_match("/(arn:aws:sns[^ ]+)/", $message, $matches);
			
			if(isset($matches[0]) && !empty($matches[0]))
				return $matches[0];

			return false;
		}
	}

	/* Get Attributes of the Endpoint */

	public function getEndpointAttributes($arn,$token) {
		try {
			$result = $this->sns->getEndpointAttributes(array(
    			// EndpointArn is required
    			'EndpointArn' => $arn
			));
			return ($result['Attributes']['Token'] != $token || $result['Attributes']['Enabled'] == "false");
		}
        catch(Exception $e) {
			return -1;
        }
	}

	/* set Attributes for the endpoint */

	function setEndpointAttributes($token,$enabled,$arn) {

		try {
			$result = $this->sns->setEndpointAttributes(array(
    			// EndpointArn is required
    			'EndpointArn' => $arn,
    			// Attributes is required
    			'Attributes' => array(
        			// Associative array of custom 'String' key names
        			'Token' => $token,
        			'Enabled' => $enabled
    			),
			));

			return $result;
		}
		catch(Exception $e) {

			return false;
		}
	}

}