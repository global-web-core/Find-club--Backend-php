<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'citiesbycountry.php';

	class CitiesbycountriesBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM citiesbycountries' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'citiesbycountryInfo');
		}

		public function add(citiesbycountryInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO citiesbycountries ( IdCountry, IdCity, Status ) VALUES ( ' . parent::value(isset($data->idCountry) ? $data->idCountry : NULL) . ', ' . parent::value(isset($data->idCity) ? $data->idCity : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(citiesbycountryInfo $data, $conditions) {
			$this->conn->prepare('UPDATE citiesbycountries SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM citiesbycountries' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/citiesbycountries.php';

?>