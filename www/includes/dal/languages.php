<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'languag.php';

	class LanguagesBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM languages' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'languagInfo');
		}

		public function add(languagInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO languages ( Name, Route, IdCountry ) VALUES ( ' . parent::quote(isset($data->name) ? $data->name : NULL) . ', ' . parent::quote(isset($data->route) ? $data->route : NULL) . ', ' . parent::value(isset($data->idCountry) ? $data->idCountry : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(languagInfo $data, $conditions) {
			$this->conn->prepare('UPDATE languages SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM languages' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/languages.php';

?>