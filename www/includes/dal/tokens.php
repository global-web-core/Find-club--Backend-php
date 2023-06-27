<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'token.php';

	class TokensBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM tokens' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'tokenInfo');
		}

		public function add(tokenInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO tokens ( UserId, Token, DateCreate, DateExpire ) VALUES ( ' . parent::value(isset($data->userId) ? $data->userId : NULL) . ', ' . parent::quote(isset($data->token) ? $data->token : NULL) . ', UNIX_TIMESTAMP(), ' . parent::value(isset($data->dateExpire) ? $data->dateExpire : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(tokenInfo $data, $conditions) {
			$this->conn->prepare('UPDATE tokens SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM tokens' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/tokens.php';

?>