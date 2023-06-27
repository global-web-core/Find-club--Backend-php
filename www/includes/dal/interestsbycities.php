<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'interestsbycity.php';

	class InterestsbycitiesBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM interestsbycities' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'interestsbycityInfo');
		}

		public function add(interestsbycityInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO interestsbycities ( IdInterest, IdCity, AmountActivity, Status ) VALUES ( ' . parent::value(isset($data->idInterest) ? $data->idInterest : NULL) . ', ' . parent::value(isset($data->idCity) ? $data->idCity : NULL) . ', ' . parent::value(isset($data->amountActivity) ? $data->amountActivity : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(interestsbycityInfo $data, $conditions) {
			$this->conn->prepare('UPDATE interestsbycities SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM interestsbycities' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/interestsbycities.php';

?>