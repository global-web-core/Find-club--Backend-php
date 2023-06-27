<?php

	class sessionInfo {

		public $id, $expires, $sessionToken, $userId;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? $data['id'] : null;
					$this->expires = isset($data['expires']) ? $data['expires'] : null;
					$this->sessionToken = isset($data['sessionToken']) ? $data['sessionToken'] : null;
					$this->userId = isset($data['userId']) ? $data['userId'] : null;
				}
				else {
					$this->id = $data['Id'];
					$this->expires = $data['Expires'];
					$this->sessionToken = $data['SessionToken'];
					$this->userId = $data['UserId'];
				}
			}
			return $this;
		}

		public static function create($id, $expires = null, $sessionToken = null, $userId = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->expires = $expires;
			$instance->sessionToken = $sessionToken;
			$instance->userId = $userId;
			return $instance;
		}

	}

?>