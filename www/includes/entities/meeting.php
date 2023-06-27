<?php

	class meetingInfo {

		public $id, $idCountry, $idCity, $idInterest, $idCategory, $idLanguage, $dateMeeting, $placeMeeting, $typeMeeting, $dateCreation, $dateModification, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->idCountry = isset($data['idCountry']) ? (int)$data['idCountry'] : 0;
					$this->idCity = isset($data['idCity']) ? (int)$data['idCity'] : 0;
					$this->idInterest = isset($data['idInterest']) ? (int)$data['idInterest'] : 0;
					$this->idCategory = isset($data['idCategory']) ? (int)$data['idCategory'] : 0;
					$this->idLanguage = isset($data['idLanguage']) ? (int)$data['idLanguage'] : 0;
					$this->dateMeeting = isset($data['dateMeeting']) ? $data['dateMeeting'] : null;
					$this->placeMeeting = isset($data['placeMeeting']) ? $data['placeMeeting'] : null;
					$this->typeMeeting = isset($data['typeMeeting']) ? (int)$data['typeMeeting'] : 0;
					$this->dateCreation = isset($data['dateCreation']) ? $data['dateCreation'] : null;
					$this->dateModification = isset($data['dateModification']) ? $data['dateModification'] : null;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->idCountry = (int)$data['IdCountry'];
					$this->idCity = (int)$data['IdCity'];
					$this->idInterest = (int)$data['IdInterest'];
					$this->idCategory = (int)$data['IdCategory'];
					$this->idLanguage = (int)$data['IdLanguage'];
					$this->dateMeeting = $data['DateMeeting'];
					$this->placeMeeting = $data['PlaceMeeting'];
					$this->typeMeeting = (int)$data['TypeMeeting'];
					$this->dateCreation = $data['DateCreation'];
					$this->dateModification = $data['DateModification'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $idCountry = null, $idCity = null, $idInterest = null, $idCategory = null, $idLanguage = null, $dateMeeting = null, $placeMeeting = null, $typeMeeting = null, $dateCreation = null, $dateModification = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->idCountry = $idCountry;
			$instance->idCity = $idCity;
			$instance->idInterest = $idInterest;
			$instance->idCategory = $idCategory;
			$instance->idLanguage = $idLanguage;
			$instance->dateMeeting = $dateMeeting;
			$instance->placeMeeting = $placeMeeting;
			$instance->typeMeeting = $typeMeeting;
			$instance->dateCreation = $dateCreation;
			$instance->dateModification = $dateModification;
			$instance->status = $status;
			return $instance;
		}

	}

?>