<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'interestsbycity.php';

	class InterestsbycityBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM interestsbycity' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'interestsbycityInfo');
		}

		public function add(interestsbycityInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO interestsbycity (  ) VALUES (  )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(interestsbycityInfo $data, $conditions) {
			$this->conn->prepare('UPDATE interestsbycity SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM interestsbycity' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/interestsbycity.php';

?>