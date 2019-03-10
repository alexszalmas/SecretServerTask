<?php
	include "config.php";
	
	class Secret {
		private $uniqueHash;
		private $secret;
		private $expAftViews;
		private $expAft;
		private $db;
		private $strcAt;
		private $streAt;
		
		
		public function __construct() {
			
		}
		
		
		public function addSecret($db, $secretText, $expAftViews, $expAft) {
			$this->db = $db;
			$this->secret = $secretText;
			$this->expAftViews = $expAftViews;
			$this->expAft = $expAft;
			
			do {
				$this->uniqueHash = $this->generateUniqueHash();
				$result = $this->db->queryHash($this->uniqueHash);
			} while($result != false);
			
			$createdAt = $this->generateCreateAt();
			$this->generateExpiresAt($createdAt);

			$this->db->insertSecret($this->uniqueHash, $this->secret, $this->strcAt,
				$this->streAt, $this->expAftViews);
		}
		
		
		public function getSecretByHash($db, $hash) {
			$this->db = $db;
			$this->uniqueHash = $hash;
			
			$this->db->updateSecret($this->uniqueHash);
			
			$result = $this->db->queryHash($this->uniqueHash);
			
			if ($result != false) {
				$this->secret = $result[1];
				$this->strcAt = $result[2];
				
				if ($result[2] == $result[3]){
					$this->streAt = $result[3];
				} elseif ($this->compareDateTime($result[3])) {
					$this->streAt = $result[3];
				} else {
					$this->db->deleteSecret($this->uniqueHash);
					return false;
				}
				
				if ($result[4] != 0) {
					$this->expAftViews = $result[4];
				} else {
					$this->db->deleteSecret($this->uniqueHash);
					return false;
				}
				
				return true;
			} else {
				return false;
			}
		}
		
		
		private function compareDateTime($dateTime) {
			$streAtObj = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
			$todayDateTime = date('Y-m-d H:i:s');
			$todayDateTimeObj = DateTime::createFromFormat('Y-m-d H:i:s', $todayDateTime);
			
			if ($streAtObj > $todayDateTimeObj) {
				return true;
			} else {
				return false;
			}
		}
		

		private function generateCreateAt() {
			$createdAt = new DateTime(date('Y-m-d H:i:s'));
			$this->strcAt = $createdAt->format('Y-m-d H:i:s');
			
			return $createdAt;
		}
		
		
		private function generateExpiresAt($createdAt) {
			$createdAt->add(new DateInterval('PT'.$this->expAft.'M'));
			$this->streAt = $createdAt->format('Y-m-d H:i:s');
		}


		private function generateUniqueHash() {
			$charset = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charsetLength = strlen($charset);
			$randomString = '';
			for ($i = 0; $i < 10; $i++) {
				$randomString .= $charset[rand(0, $charsetLength - 1)];
			}
			return $randomString;
		}
		
		
		public function getHash() {
			return $this->uniqueHash;
		}
		
		public function getStrcAt() {
			return $this->strcAt;
		}
		
		public function getStreAt() {
			return $this->streAt;
		}
		
		public function getSecret() {
			return $this->secret;
		}
		
		public function getExpAftViews() {
			return $this->expAftViews;
		}
	}
?>