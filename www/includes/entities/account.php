<?php

	class accountInfo {

		public $id, $userId, $type, $provider, $providerAccountId, $refresh_token, $access_token, $expires_at, $token_type, $scope, $id_token, $session_state, $oauth_token_secret, $oauth_token;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? $data['id'] : null;
					$this->userId = isset($data['userId']) ? $data['userId'] : null;
					$this->type = isset($data['type']) ? $data['type'] : null;
					$this->provider = isset($data['provider']) ? $data['provider'] : null;
					$this->providerAccountId = isset($data['providerAccountId']) ? $data['providerAccountId'] : null;
					$this->refresh_token = isset($data['refresh_token']) ? $data['refresh_token'] : null;
					$this->access_token = isset($data['access_token']) ? $data['access_token'] : null;
					$this->expires_at = isset($data['expires_at']) ? (int)$data['expires_at'] : 0;
					$this->token_type = isset($data['token_type']) ? $data['token_type'] : null;
					$this->scope = isset($data['scope']) ? $data['scope'] : null;
					$this->id_token = isset($data['id_token']) ? $data['id_token'] : null;
					$this->session_state = isset($data['session_state']) ? $data['session_state'] : null;
					$this->oauth_token_secret = isset($data['oauth_token_secret']) ? $data['oauth_token_secret'] : null;
					$this->oauth_token = isset($data['oauth_token']) ? $data['oauth_token'] : null;
				}
				else {
					$this->id = $data['Id'];
					$this->userId = $data['UserId'];
					$this->type = $data['Type'];
					$this->provider = $data['Provider'];
					$this->providerAccountId = $data['ProviderAccountId'];
					$this->refresh_token = $data['Refresh_token'];
					$this->access_token = $data['Access_token'];
					$this->expires_at = (int)$data['Expires_at'];
					$this->token_type = $data['Token_type'];
					$this->scope = $data['Scope'];
					$this->id_token = $data['Id_token'];
					$this->session_state = $data['Session_state'];
					$this->oauth_token_secret = $data['Oauth_token_secret'];
					$this->oauth_token = $data['Oauth_token'];
				}
			}
			return $this;
		}

		public static function create($id, $userId = null, $type = null, $provider = null, $providerAccountId = null, $refresh_token = null, $access_token = null, $expires_at = null, $token_type = null, $scope = null, $id_token = null, $session_state = null, $oauth_token_secret = null, $oauth_token = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->userId = $userId;
			$instance->type = $type;
			$instance->provider = $provider;
			$instance->providerAccountId = $providerAccountId;
			$instance->refresh_token = $refresh_token;
			$instance->access_token = $access_token;
			$instance->expires_at = $expires_at;
			$instance->token_type = $token_type;
			$instance->scope = $scope;
			$instance->id_token = $id_token;
			$instance->session_state = $session_state;
			$instance->oauth_token_secret = $oauth_token_secret;
			$instance->oauth_token = $oauth_token;
			return $instance;
		}

	}

?>