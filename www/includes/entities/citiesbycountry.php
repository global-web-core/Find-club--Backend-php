<?php

	class citiesbycountryInfo {

		public $id, $idCountry, $idCity, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->idCountry = isset($data['idCountry']) ? (int)$data['idCountry'] : 0;
					$this->idCity = isset($data['idCity']) ? (int)$data['idCity'] : 0;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->idCountry = (int)$data['IdCountry'];
					$this->idCity = (int)$data['IdCity'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $idCountry = null, $idCity = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->idCountry = $idCountry;
			$instance->idCity = $idCity;
			$instance->status = $status;
			return $instance;
		}

	}

?>