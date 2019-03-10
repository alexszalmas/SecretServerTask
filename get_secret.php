<?php
	include "secret_obj.php";
	include "response.php";
	include "dbutils.php";
	
	$hash = $_GET['url'];
	//echo $hash;
	$db = new DB(CONFIG_SERVER_NAME, CONFIG_DB_USER, 
		CONFIG_DB_PW, CONFIG_DB_NAME);
	
	$secretObj = new Secret();
	$success = $secretObj->getSecretByHash($db, $hash);
	
	if ($success) {
		$responseObj = new Response($secretObj);
	} else {
		header('HTTP/1.0 404 Not Found');
	}
	
?>