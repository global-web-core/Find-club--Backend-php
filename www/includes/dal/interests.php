<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'interest.php';

	class InterestsBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM interests' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'interestInfo');
		}

		public function add(interestInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO interests ( Interest, Route, Status ) VALUES ( ' . parent::quote(isset($data->interest) ? $data->interest : NULL) . ', ' . parent::quote(isset($data->route) ? $data->route : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(interestInfo $data, $conditions) {
			$this->conn->prepare('UPDATE interests SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM interests' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/interests.php';

?>