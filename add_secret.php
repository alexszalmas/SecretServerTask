<?php
	include "secret_obj.php";
	include "response.php";
	include "dbutils.php";
	
	$uniqueHash = "";
	$secret = $_POST['secret'];
	$expAftViews = $_POST['expireAfterViews'];
	$expAft = $_POST['expireAfter'];
	
	$db = new DB(CONFIG_SERVER_NAME, CONFIG_DB_USER, 
		CONFIG_DB_PW, CONFIG_DB_NAME);
	
	$secretObj = new Secret();
	$secretObj->addSecret($db, $secret, $expAftViews, $expAft);
	
	$responseObj = new Response($secretObj);
?>