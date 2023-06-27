<?php

	class interestsbycityInfo {

		public $id, $idInterest, $idCity, $amountActivity, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->idInterest = isset($data['idInterest']) ? (int)$data['idInterest'] : 0;
					$this->idCity = isset($data['idCity']) ? (int)$data['idCity'] : 0;
					$this->amountActivity = isset($data['amountActivity']) ? (int)$data['amountActivity'] : 0;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->idInterest = (int)$data['IdInterest'];
					$this->idCity = (int)$data['IdCity'];
					$this->amountActivity = (int)$data['AmountActivity'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $idInterest = null, $idCity = null, $amountActivity = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->idInterest = $idInterest;
			$instance->idCity = $idCity;
			$instance->amountActivity = $amountActivity;
			$instance->status = $status;
			return $instance;
		}

	}

?>