<?php
	
	class Response {
	
		private $hash;
		private $secret;
		private $createdAt;
		private $expiresAt;
		private $remainingViews;
		//private $secretObj;
		
		function __construct ($secretObj){
			$this->hash = $secretObj->getHash();
			$this->secret = $secretObj->getSecret();
			$this->createdAt = $secretObj->getStrcAt();
			$this->expiresAt = $secretObj->getStreAt();
			$this->remainingViews = $secretObj->getExpAftViews();
			$this->chooseResponse();
		}
		
		private function chooseResponse() {
			if (CONFIG_RESPONSE_TYPE == "xml") {
				header("Content-type: application/xml");

				echo "<?xml version='1.0' encoding='UTF-8'?>";
				echo "<Secret>";
				echo "<hash>".$this->hash."<description>Unique hash to identify the secrets.
					</description></hash>";
				echo "<secretText>".$this->secret."<description>The secret itself.
					</description></secretText>";
				echo "<createdAt>".$this->createdAt."<description>The date and time of the creation.
					</description></createdAt>";
				echo "<expiresAt>".$this->expiresAt."<description>The secret cannot be reached after
					this time.</description></expiresAt>";
				echo "<remainingViews>".$this->remainingViews."<description>How many times the secret
					can be viewed.</description></remainingViews>";
				echo "</Secret>";
			} else {
				header("Content-type: application/json");

				$jsonString =  '{
   "hash": {
	  "#text": "'.$this->hash.'",
	  "description": "Unique hash to identify the secrets."
   },
   "secretText": {
	  "#text": "'.$this->secret.'",
	  "description": "The secret itself."
   },
   "createdAt": {
	  "#text": "'.$this->createdAt.'",
	  "description": "The date and time of the creation."
   },
   "expiresAt": {
	  "#text": "'.$this->expiresAt.'",
	  "description": "The secret cannot be reached after this time."
   },
   "remainingViews": {
	  "#text": "'.$this->remainingViews.'",
	  "description": "How many times the secret can be viewed."
   }
}';

				echo $jsonString;
			}
		}
	}
?>