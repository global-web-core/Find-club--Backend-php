<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'languagetranslationen.php';

	class LanguagetranslationenBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM languagetranslationen' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'languagetranslationenInfo');
		}

		public function add(languagetranslationenInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO languagetranslationen ( NameText, Translation ) VALUES ( ' . parent::quote(isset($data->nameText) ? $data->nameText : NULL) . ', ' . parent::quote(isset($data->translation) ? $data->translation : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(languagetranslationenInfo $data, $conditions) {
			$this->conn->prepare('UPDATE languagetranslationen SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM languagetranslationen' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/languagetranslationen.php';

?>