<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'category.php';

	class CategoriesBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM categories' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'categoryInfo');
		}

		public function add(categoryInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO categories ( NameCategory, Route, Status ) VALUES ( ' . parent::quote(isset($data->nameCategory) ? $data->nameCategory : NULL) . ', ' . parent::quote(isset($data->route) ? $data->route : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(categoryInfo $data, $conditions) {
			$this->conn->prepare('UPDATE categories SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM categories' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/categories.php';

?>