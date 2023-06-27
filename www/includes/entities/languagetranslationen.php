<?php

	class languagetranslationenInfo {

		public $id, $nameText, $translation;

		function __construct($data = null, $fromArray = false) {
			if (!is_null($data)) {
				if ($fromArray) {
					$this->id = isset($data['id']) ? (int)$data['id'] : 0;
					$this->nameText = isset($data['nameText']) ? $data['nameText'] : null;
					$this->translation = isset($data['translation']) ? $data['translation'] : null;
				}
				else {
					$this->id = (int)$data['Id'];
					$this->nameText = $data['NameText'];
					$this->translation = $data['Translation'];
				}
			}
			return $this;
		}

		public static function create($id, $nameText = null, $translation = null) {
			$instance = new self(null);
			$instance->id = $id;
			$instance->nameText = $nameText;
			$instance->translation = $translation;
			return $instance;
		}

	}

?>