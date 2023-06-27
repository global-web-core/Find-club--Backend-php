<?php

	require_once __DAL			. 'base.php';
	require_once __ENTITIES		. 'meeting.php';

	class MeetingsBase extends Base {

		public function get($conditions, $orders, $limits) {
			$stmt = $this->conn->prepare('SELECT * FROM meetings' . parent::conditions($conditions) . parent::orders($orders) . parent::limits($limits));
			$stmt->execute();
			return parent::set($stmt, true, 'meetingInfo');
		}

		public function add(meetingInfo $data) {
			$optionWithDateModification = 'INSERT INTO meetings ( IdCountry, IdCity, IdInterest, IdCategory, IdLanguage, DateMeeting, PlaceMeeting, TypeMeeting, DateCreation, DateModification, Status ) VALUES ( ' . parent::value(isset($data->idCountry) ? $data->idCountry : NULL) . ', ' . parent::value(isset($data->idCity) ? $data->idCity : NULL) . ', ' . parent::value(isset($data->idInterest) ? $data->idInterest : NULL) . ', ' . parent::value(isset($data->idCategory) ? $data->idCategory : NULL) . ', ' . parent::value(isset($data->idLanguage) ? $data->idLanguage : NULL) . ', ' . parent::quote(isset($data->dateMeeting) ? $data->dateMeeting : NULL) . ', ' . parent::quote(isset($data->placeMeeting) ? $data->placeMeeting : NULL) . ', ' . parent::value(isset($data->typeMeeting) ? $data->typeMeeting : NULL) . ', ' . parent::quote(isset($data->dateCreation) ? $data->dateCreation : NULL) . ', ' . parent::quote(isset($data->dateModification) ? $data->dateModification : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )';

			$optionWithoutDateModification = 'INSERT INTO meetings ( IdCountry, IdCity, IdInterest, IdCategory, IdLanguage, DateMeeting, PlaceMeeting, TypeMeeting, DateCreation, Status ) VALUES ( ' . parent::value(isset($data->idCountry) ? $data->idCountry : NULL) . ', ' . parent::value(isset($data->idCity) ? $data->idCity : NULL) . ', ' . parent::value(isset($data->idInterest) ? $data->idInterest : NULL) . ', ' . parent::value(isset($data->idCategory) ? $data->idCategory : NULL) . ', ' . parent::value(isset($data->idLanguage) ? $data->idLanguage : NULL) . ', ' . parent::quote(isset($data->dateMeeting) ? $data->dateMeeting : NULL) . ', ' . parent::quote(isset($data->placeMeeting) ? $data->placeMeeting : NULL) . ', ' . parent::value(isset($data->typeMeeting) ? $data->typeMeeting : NULL) . ', ' . parent::quote(isset($data->dateCreation) ? $data->dateCreation : NULL) . ', ' . parent::value(isset($data->status) ? $data->status : NULL) . ' )';

			$sqlRequest = null;

			if (isset($data->dateModification)) {
				$sqlRequest = $optionWithDateModification;
			} else {
				$sqlRequest = $optionWithoutDateModification;
			}
			
			$stmt = $this->conn->prepare($sqlRequest);
			$stmt->execute();
			return array('id' => $this->conn->lastInsertId());
		}

		public function update(meetingInfo $data, $conditions) {
			$this->conn->prepare('UPDATE meetings SET ' . parent::updates($data) . parent::conditions($conditions))->execute();
		}

		public function delete($conditions) {
			$this->conn->prepare('DELETE FROM meetings' . parent::conditions($conditions))->execute();
		}

	}

	require_once 'ext/meetings.php';

?>