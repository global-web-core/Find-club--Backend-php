<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'verificationtoken.php';

	class VerificationtokensBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM verificationtokens' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'verificationtokenInfo');
		}

		public function add(verificationtokenInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO verificationtokens ( Identifier, Token, Expires ) VALUES ( ' . parent::quote(isset($data->identifier) ? $data->identifier : NULL) . ', ' . parent::quote(isset($data->token) ? $data->token : NULL) . ', ' . parent::quote(isset($data->expires) ? $data->expires : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(verificationtokenInfo $data, $conditions) {
			$this->conn->prepare('UPDATE verificationtokens SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM verificationtokens' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/verificationtokens.php';

?>