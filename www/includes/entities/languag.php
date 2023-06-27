<?php

	class languagInfo {

		public $id, $name, $route, $idCountry;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->name = isset($data['name']) ? $data['name'] : null;
					$this->route = isset($data['route']) ? $data['route'] : null;
					$this->idCountry = isset($data['idCountry']) ? (int)$data['idCountry'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->name = $data['Name'];
					$this->route = $data['Route'];
					$this->idCountry = (int)$data['IdCountry'];
				}
			}
			return $this;
		}

		public static function create($id, $name = null, $route = null, $idCountry = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->name = $name;
			$instance->route = $route;
			$instance->idCountry = $idCountry;
			return $instance;
		}

	}

?>