<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'user.php';

	class UsersBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM users' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'userInfo');
		}

		public function add(userInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO users ( Id, Name, Email, EmailVerified, Image ) VALUES ( ' . parent::quote(isset($data->id) ? $data->id : NULL) . ', ' . parent::quote(isset($data->name) ? $data->name : NULL) . ', ' . parent::quote(isset($data->email) ? $data->email : NULL) . ', ' . parent::quote(isset($data->emailVerified) ? $data->emailVerified : NULL) . ', ' . parent::quote(isset($data->image) ? $data->image : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(userInfo $data, $conditions) {
			$this->conn->prepare('UPDATE users SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM users' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/users.php';

?>