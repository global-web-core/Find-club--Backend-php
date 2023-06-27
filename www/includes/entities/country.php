<?php

	class countryInfo {

		public $id, $nameCountry, $route, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->nameCountry = isset($data['nameCountry']) ? $data['nameCountry'] : null;
					$this->route = isset($data['route']) ? $data['route'] : null;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->nameCountry = $data['NameCountry'];
					$this->route = $data['Route'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $nameCountry = null, $route = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->nameCountry = $nameCountry;
			$instance->route = $route;
			$instance->status = $status;
			return $instance;
		}

	}

?>