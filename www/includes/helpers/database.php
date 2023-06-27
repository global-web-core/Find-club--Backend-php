<?php

	class database {

		private $host = 'localhost', $db_name, $username, $password;
		public $conn;

		public function __construct($host, $db_name, $username, $password) {
			$this->host = $host;
			$this->db_name = $db_name;
			$this->username = $username;
			$this->password = $password;
		}

		// get the database connection
		public function getConnection() {
			$this->conn = null;
			try {
				$options = array(
				    PDO::ATTR_ERRMODE				=> PDO::ERRMODE_EXCEPTION,
				    PDO::ATTR_DEFAULT_FETCH_MODE	=> PDO::FETCH_OBJ,
				);
				$this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password, $options);
				$this->conn->exec('set names utf8');
			}
			catch (PDOException $exception) {
				throw new DBException('Connection error: ' . $exception->getMessage());
			}
			return $this->conn;
		}

	}

?>