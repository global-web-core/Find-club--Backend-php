<?php

	class verificationtokenInfo {

		public $identifier, $token, $expires;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->identifier = isset($data['identifier']) ? $data['identifier'] : null;
					$this->token = isset($data['token']) ? $data['token'] : null;
					$this->expires = isset($data['expires']) ? $data['expires'] : null;
				}
				else {
					$this->identifier = $data['Identifier'];
					$this->token = $data['Token'];
					$this->expires = $data['Expires'];
				}
			}
			return $this;
		}

		public static function create($identifier, $token = null, $expires = null) {
			$instance = new self(null);
			$instance->identifier = $identifier;
			$instance->token = $token;
			$instance->expires = $expires;
			return $instance;
		}

	}

?>