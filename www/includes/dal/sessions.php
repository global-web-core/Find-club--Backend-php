<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'session.php';

	class SessionsBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM sessions' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'sessionInfo');
		}

		public function add(sessionInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO sessions ( Id, Expires, SessionToken, UserId ) VALUES ( ' . parent::quote(isset($data->id) ? $data->id : NULL) . ', ' . parent::quote(isset($data->expires) ? $data->expires : NULL) . ', ' . parent::quote(isset($data->sessionToken) ? $data->sessionToken : NULL) . ', ' . parent::quote(isset($data->userId) ? $data->userId : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(sessionInfo $data, $conditions) {
			$this->conn->prepare('UPDATE sessions SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM sessions' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/sessions.php';

?>