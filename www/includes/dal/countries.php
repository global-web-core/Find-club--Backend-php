<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'country.php';

	class CountriesBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM countries' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'countryInfo');
		}

		public function add(countryInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO countries ( NameCountry, Route, Status ) VALUES ( ' . parent::quote(isset($data->nameCountry) ? $data->nameCountry : NULL) . ', ' . parent::quote(isset($data->route) ? $data->route : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(countryInfo $data, $conditions) {
			$this->conn->prepare('UPDATE countries SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM countries' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/countries.php';

?>