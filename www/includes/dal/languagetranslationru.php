<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'languagetranslationru.php';

	class LanguagetranslationruBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM languagetranslationru' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'languagetranslationruInfo');
		}

		public function add(languagetranslationruInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO languagetranslationru ( NameText, Translation ) VALUES ( ' . parent::quote(isset($data->nameText) ? $data->nameText : NULL) . ', ' . parent::quote(isset($data->translation) ? $data->translation : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(languagetranslationruInfo $data, $conditions) {
			$this->conn->prepare('UPDATE languagetranslationru SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM languagetranslationru' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/languagetranslationru.php';

?>