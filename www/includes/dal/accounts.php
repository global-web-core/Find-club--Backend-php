<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'account.php';

	class AccountsBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM accounts' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'accountInfo');
		}

		public function add(accountInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO accounts ( Id, UserId, Type, Provider, ProviderAccountId, Refresh_token, Access_token, Expires_at, Token_type, Scope, Id_token, Session_state, Oauth_token_secret, Oauth_token ) VALUES ( ' . parent::quote(isset($data->id) ? $data->id : NULL) . ', ' . parent::quote(isset($data->userId) ? $data->userId : NULL) . ', ' . parent::quote(isset($data->type) ? $data->type : NULL) . ', ' . parent::quote(isset($data->provider) ? $data->provider : NULL) . ', ' . parent::quote(isset($data->providerAccountId) ? $data->providerAccountId : NULL) . ', ' . parent::quote(isset($data->refresh_token) ? $data->refresh_token : NULL) . ', ' . parent::quote(isset($data->access_token) ? $data->access_token : NULL) . ', ' . parent::value(isset($data->expires_at) ? $data->expires_at : NULL) . ', ' . parent::quote(isset($data->token_type) ? $data->token_type : NULL) . ', ' . parent::quote(isset($data->scope) ? $data->scope : NULL) . ', ' . parent::quote(isset($data->id_token) ? $data->id_token : NULL) . ', ' . parent::quote(isset($data->session_state) ? $data->session_state : NULL) . ', ' . parent::quote(isset($data->oauth_token_secret) ? $data->oauth_token_secret : NULL) . ', ' . parent::quote(isset($data->oauth_token) ? $data->oauth_token : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(accountInfo $data, $conditions) {
			$this->conn->prepare('UPDATE accounts SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM accounts' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/accounts.php';

?>