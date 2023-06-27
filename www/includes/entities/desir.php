<?php

	class desirInfo {

		public $id, $idUser, $idMeeting, $statusOrganizer, $statusWish, $statusReadiness, $status;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->idUser = isset($data['idUser']) ? $data['idUser'] : null;
					$this->idMeeting = isset($data['idMeeting']) ? (int)$data['idMeeting'] : 0;
					$this->statusOrganizer = isset($data['statusOrganizer']) ? (int)$data['statusOrganizer'] : 0;
					$this->statusWish = isset($data['statusWish']) ? (int)$data['statusWish'] : 0;
					$this->statusReadiness = isset($data['statusReadiness']) ? (int)$data['statusReadiness'] : 0;
					$this->status = isset($data['status']) ? (int)$data['status'] : 0;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->idUser = $data['IdUser'];
					$this->idMeeting = (int)$data['IdMeeting'];
					$this->statusOrganizer = (int)$data['StatusOrganizer'];
					$this->statusWish = (int)$data['StatusWish'];
					$this->statusReadiness = (int)$data['StatusReadiness'];
					$this->status = (int)$data['Status'];
				}
			}
			return $this;
		}

		public static function create($id, $idUser = null, $idMeeting = null, $statusOrganizer = null, $statusWish = null, $statusReadiness = null, $status = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->idUser = $idUser;
			$instance->idMeeting = $idMeeting;
			$instance->statusOrganizer = $statusOrganizer;
			$instance->statusWish = $statusWish;
			$instance->statusReadiness = $statusReadiness;
			$instance->status = $status;
			return $instance;
		}

	}

?>