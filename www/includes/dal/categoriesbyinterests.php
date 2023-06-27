<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'categoriesbyinterest.php';

	class CategoriesbyinterestsBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM categoriesbyinterests' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'categoriesbyinterestInfo');
		}

		public function add(categoriesbyinterestInfo $data) {
			$stmt = $this->conn->prepare('INSERT INTO categoriesbyinterests ( IdInterest, IdCategory, Status ) VALUES ( ' . parent::value(isset($data->idInterest) ? $data->idInterest : NULL) . ', ' . parent::value(isset($data->idCategory) ? $data->idCategory : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )');
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(categoriesbyinterestInfo $data, $conditions) {
			$this->conn->prepare('UPDATE categoriesbyinterests SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM categoriesbyinterests' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/categoriesbyinterests.php';

?>