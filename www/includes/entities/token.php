<?php

	class tokenInfo {

		public $id, $userId, $token, $dateCreate, $dateExpire;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->userId = isset($data['userId']) ? (int)$data['userId'] : 0;
					$this->token = isset($data['token']) ? $data['token'] : null;
					$this->dateCreate = isset($data['dateCreate']) ? (int)$data['dateCreate'] : 0;
					$this->dateExpire = isset($data['dateExpire']) ? (int)$data['dateExpire'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->userId = (int)$data['UserId'];
					$this->token = $data['Token'];
					$this->dateCreate = (int)$data['DateCreate'];
					$this->dateExpire = (int)$data['DateExpire'];
				}
			}
			return $this;
		}

		public static function create($id, $userId = null, $token = null, $dateCreate = null, $dateExpire = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->userId = $userId;
			$instance->token = $token;
			$instance->dateCreate = $dateCreate;
			$instance->dateExpire = $dateExpire;
			return $instance;
		}

	}

?>