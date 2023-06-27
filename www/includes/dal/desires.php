<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'desir.php';

	class DesiresBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM desires' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'desirInfo');
		}

		public function add(desirInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO desires ( IdUser, IdMeeting, StatusOrganizer, StatusWish, StatusReadiness, Status ) VALUES ( ' . parent::quote(isset($data->idUser) ? $data->idUser : NULL) . ', ' . parent::value(isset($data->idMeeting) ? $data->idMeeting : NULL) . ', ' . parent::value(isset($data->statusOrganizer) ? $data->statusOrganizer : NULL) . ', ' . parent::value(isset($data->statusWish) ? $data->statusWish : NULL) . ', ' . parent::value(isset($data->statusReadiness) ? $data->statusReadiness : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(desirInfo $data, $conditions) {
			$this->conn->prepare('UPDATE desires SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM desires' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/desires.php';

?>