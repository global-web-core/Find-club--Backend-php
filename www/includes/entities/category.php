<?php

	class categoryInfo {

		public $id, $nameCategory, $route, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->nameCategory = isset($data['nameCategory']) ? $data['nameCategory'] : null;
					$this->route = isset($data['route']) ? $data['route'] : null;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->nameCategory = $data['NameCategory'];
					$this->route = $data['Route'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $nameCategory = null, $route = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->nameCategory = $nameCategory;
			$instance->route = $route;
			$instance->status = $status;
			return $instance;
		}

	}

?>