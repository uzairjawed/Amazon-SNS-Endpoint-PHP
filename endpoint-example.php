<?php

require 'config.php';
require 'sns.class.php';

$token = ""; // a device/app token or registration id returned from GCM/APNS.

$sns = new EndpointSNS(AMAZON_KEY,AMAZON_SECRET);

/* query your database with the token */ 
$query = "select * from devices where token = '".$token."'";

$result = $mysqli->query($query);

if($result->num_rows == 0) { // first time user.
    $endpointArn = $sns->generateEndpoint($token,SNS_PLATFORM_ARN);
    
	$query = "insert into devices set token = '".$token."',endpoint_arn = '".$endpointArn."'";			
	$mysqli->query($query);
}
else { // subsequent user with the same token
	$query = "update devices set updated_on = '".date("Y-m-d H:i:s")."' where token = '".$token."'";
	$mysqli->query($query);
}

// get the attributes of the Endpoint ARN and check if it is still a valid token and enabled or not.
$endpointAtt = $sns->getEndpointAttributes($endpointArn,$token);

if($endpointAtt == true) { // Endpoint is either have invalid token or it is marked as disabled.
	$sns->setEndpointAttributes($token,"true",$endpointArn);
}
else if($endpointAtt == -1) { // Endpoint doesn't exist, delete the one you have from the DB and generate a new endpoint.

	$query = "delete from devices where token = '".$token."'";
	$mysqli->query($query);
	$endpointArn = $sns->generateEndpoint($token,SNS_PLATFORM_ARN);
	
	$query = "insert into devices set token = '".$token."',endpoint_arn = '".$endpointArn."'";			
	$mysqli->query($query);
}

?>