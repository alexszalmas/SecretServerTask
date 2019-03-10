<?php
	class DB
	{
		public $conn;
		private $serverName; 
		private $username;
		private $password;
		private $dbName;

   
		public function __construct($serverName, $username, $password, $dbName) {
			// Create connection1
			$this->serverName = $serverName;
			$this->username = $username;
			$this->password = $password;
			$this->dbName = $dbName;
			$this->connect();
    	}
		
		
		public function connect(){
			try {
				$this->conn = new PDO('mysql:host=' . $this->serverName . 
					';dbname=' . $this->dbName, $this->username, $this->password, 
					[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
				);
				$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->conn->setAttribute(PDO::ATTR_TIMEOUT, 500);
			} catch(PDOException $e) {
				echo $e->getMessage();
				die();
        	}
		}
		
		
		public function queryHash($hash){
			$sql = "SELECT * FROM secrets WHERE hash = '$hash'";
			$statement = $this->conn->query($sql);
			$result = $statement->fetch();
			
			return $result;
		}
		
		
		public function insertSecret($uniqueHash, $secret, $createdAt,
			$expiresAt, $expAftViews) {
			$sql = "INSERT INTO secrets (hash, secret, createdAt, expiresAt,
				remainingViews) VALUES (?,?,?,?,?)";
			$statement = $this->conn->prepare($sql);
			$statement->execute([$uniqueHash, $secret, $createdAt, $expiresAt, $expAftViews]);
		}
		
		public function deleteSecret($hash) {
			$sql = "DELETE FROM secrets WHERE hash = '$hash'";
			$statement = $this->conn->query($sql);
		}
		
		public function updateSecret($hash) {
			$sql = "UPDATE secrets SET remainingViews=remainingViews-1 WHERE hash = '$hash'";
			$statement = $this->conn->query($sql);
		}
	}
?>
