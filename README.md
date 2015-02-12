# SNS-Endpoint-PHP
Registering an app’s token with Amazon SNS efficiently.

This impelementation is based on the Amazon blog mentioned over here - http://mobile.awsblog.com/post/Tx223MJB0XKV9RU/Mobile-token-management-with-Amazon-SNS.
I have implemented the pseudo code mentioned in the blog for PHP.

# Usage 

1. Use the dump.sql file create a new devices table in your mysql database
2. Enter the database and SNS credentials in config.php
3. Replace the token with your own app/device token in endpoint-example.php


