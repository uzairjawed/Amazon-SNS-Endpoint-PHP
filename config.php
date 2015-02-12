<?php
/* Database credentials */
define("DB_HOST","");
define("DB_USER","");
define("DB_NAME","");
define("DB_PASSWORD","");

/* Amazon Credentials */
DEFINE("AMAZON_KEY",""); 
DEFINE("AMAZON_SECRET",""); 

/* SNS Platform Application ARNs */
DEFINE("SNS_PLATFORM_ARN",""); // should be of either GCM or APNS

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

?>