<?php

	class userInfo {

		public $id, $name, $email, $emailVerified, $image;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? $data['id'] : null;
					$this->name = isset($data['name']) ? $data['name'] : null;
					$this->email = isset($data['email']) ? $data['email'] : null;
					$this->emailVerified = isset($data['emailVerified']) ? $data['emailVerified'] : null;
					$this->image = isset($data['image']) ? $data['image'] : null;
				}
				else {
					$this->id = $data['Id'];
					$this->name = $data['Name'];
					$this->email = $data['Email'];
					$this->emailVerified = $data['EmailVerified'];
					$this->image = $data['Image'];
				}
			}
			return $this;
		}

		public static function create($id, $name = null, $email = null, $emailVerified = null, $image = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->name = $name;
			$instance->email = $email;
			$instance->emailVerified = $emailVerified;
			$instance->image = $image;
			return $instance;
		}

	}

?>