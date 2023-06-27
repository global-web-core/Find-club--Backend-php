<?php

	class categoriesbyinterestInfo {

		public $id, $idInterest, $idCategory, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->idInterest = isset($data['idInterest']) ? (int)$data['idInterest'] : 0;
					$this->idCategory = isset($data['idCategory']) ? (int)$data['idCategory'] : 0;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->idInterest = (int)$data['IdInterest'];
					$this->idCategory = (int)$data['IdCategory'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $idInterest = null, $idCategory = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->idInterest = $idInterest;
			$instance->idCategory = $idCategory;
			$instance->status = $status;
			return $instance;
		}

	}

?>